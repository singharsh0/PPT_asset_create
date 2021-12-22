<?php

namespace App\Controller;

use Swagger\Annotations as SWG;
use Psr\Log\LoggerInterface;
use App\Entity\AssetManagerMaster;
use Monolog\Logger;
use App\Modules\Asset\Helper\SwaggerAnnotation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
//use Swagger\Annotations\Response;

$logger=new Logger("Asset Controller");
class AssetManagerController extends AbstractController
{
    /**
    * @Route("/api/asset/create", name="user_asset_create",methods={"POST"})
    *   
    *   @OA\RequestBody(
    *     required=true,
    *     @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
    *               @OA\Property(
    *                  property="name",
    *                  type="string",
    *                  description="Name of the Asset",
    *                  maximum=255,
    *                  example="Asset Name"
    *              ),
    *              @OA\Property(
    *                  property="description",
    *                  type="string",
    *                  maximum=1000,
    *                  description="Description of the Asset",
    *                  example="Asset Description"
    *              ),
    *              @OA\Property(
    *                  property="cover_image_name",
    *                  type="string",
    *                  maximum=1000,
    *                  description="Image Name of the Asset",
    *                  example="Q1.png"
    *              ),
    *              @OA\Property(
    *                  property="effective_date",
    *                  type="string",
    *                  description="Effective start date of the Asset. Date time of the asset must be in ISO 8601 standard",
    *                  example="2018-03-19T15:19:21+00:00"
    *              ),
    *              @OA\Property(
    *                  property="expire_date",
    *                  type="string",
    *                  description="Termination date of the Asset. Date time of the asset must be in ISO 8601 standard",
    *                  example="2999-12-31T15:19:21+00:00"
    *              ),
    *              @OA\Property(
    *                  property="file_name",
    *                  type="string",
    *                  maximum=1000,
    *                  description="File Name of the Asset",
    *                  example="fa14.ppt"
    *              ),
    *              @OA\Property(
    *                  property="identifier",
    *                  type="string",
    *                  maximum=1000,
    *                  description="Unique Identifier of the Asset",
    *                  example="ASSET_PPT_2243"
    *              ),
    *              @OA\Property(
    *                  property="language",
    *                  type="string",
    *       	        description="Language of Asset",
    *                  example="English"
    *              ),
    *              @OA\Property(
    *                  property="steward",
    *                  type="string",
    *                  maximum=1000,
    *                  description="Steward of the Asset",
    *                  example="Nursing"
    *              ),
    *              
    *       ),
    *     ),
    *
    *   ),
    *   
    *   @OA\Response(response="200",
    *     description="Asset successfully created.",
    *     @OA\JsonContent(ref="#/components/schemas/AssetManagerMaster"),
    *   )
    *    @OA\Response(
    *     response="400",
    *     description="BAD REQUEST",

    *   ),
    *   @OA\Response(
    *         response="default",
    *         description="unexpected error",
    *         @OA\Schema(ref="#/components/schemas/ErrorModel")
    *     ),
    * @OA\Response(
    *     response="401",
    *     description="UnAuthorised",

    *   ),
    * @OA\Response(
    *     response="404",
    *     description="Not Found",
    *   ),
    * @OA\Response(
    *     response="500",
    *     description="Internal Server Error",

    *   ),
    * 
    * @OA\Tag(name="Asset Manager"),
    * @Security(name="Bearer") ,
    */
    // Create API Controller function for Asset Create 
    public function create(Request $request,ValidatorInterface $validator,LoggerInterface $logger)
    {
        $directory=$this->getParameter('temp');
        $ppt_extension= array("ppt","pptx");    
       
        $img_extension= array("jpg","png");   
        $img_directory=$this->getParameter('temp');

        $temp=$this->getParameter('temp');
        $permanent=$this->getParameter('permanent');
        $assets = $this->getDoctrine()
        ->getRepository(AssetManagerMaster::class)
        ->create_asset($validator,$request,$temp,$permanent,$directory,$ppt_extension,$img_extension,$logger);

        $logger->info('Create Working');
        return $assets; 
    }

    // #[Route("/api/asset/list/", name:"asset_list",methods:"GET")]
    /**
     * @Route("/api/asset/list/", name="asset_list",methods="Get")
     * @OA\Response(
     *     response=200,
     *     description="Returns the list of user data",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=AssetManagerMaster::class, groups={"full"}))
     *     )
     * )
     *   @OA\Response(
     *     response="400",
     *     description="BAD REQUEST",

     *   ),
     * @OA\Response(
     *     response="401",
     *     description="UnAuthorised",

     *   ),
     * @OA\Response(
     *     response="404",
     *     description="Not Found",

     *   ),
     * @OA\Response(
     *     response="500",
     *     description="Internal Server Error",

     *   ),
     * @OA\Parameter(
     *     name="fieldName",
     *     in="query",
     *     required=true,
     *     description="Field Name by which sorting needs to be done",
     *     example="id",
     *     @OA\Schema(type="string")
     * ),
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     required=true,
     *     description="Number of the data to be listed",
     *     example="10",
     *     @OA\Schema(type="integer")
     * ),
     * @OA\Parameter(
     *     name="offset",
     *     in="query",
     *     required=true,
     *     description="From where data should start from (OffsetX2)",
     *     example="0",
     *     @OA\Schema(type="integer")
     * ),
     *  @OA\Parameter(
     *     name="sorting",
     *     in="query",
     *     required=true,
     *     description="Order in which sorting is done ASC or DESC",
     *     example="ASC",
     *     @OA\Schema(type="string")
     * )
     * @OA\Tag(name="Asset Manager")
     * @Security(name="Bearer")    
     */
    
    // List API Controller function for Listing asset details 
    public function showAll(Request $request): Response
    {
        $limit=$request->query->get('limit');
       $offset=$request->query->get('offset');
        $fieldName=$request->query->get('fieldName');
        $sorting=$request->query->get('sorting');
       $assets = $this->getDoctrine()
       ->getRepository(AssetManagerMaster::class)
       ->list_view($request,$limit,$fieldName,$offset,$sorting);
       
       $total = $this->getDoctrine()->getRepository(AssetManagerMaster::class)->total();
        
        return $this->json(array('total'=>$total,'data'=>$assets));
     
     }   
     
    //[Route("/api/asset/preview/{id}", name:"asset_preview",methods:"GET")]
    /**
     * @Route("/api/asset/preview/{id}", name="asset_preview",methods="Get")
     * @OA\Response(
     *     response=200,
     *     description="Returns the list of user data",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=AssetManagerMaster::class, groups={"full"}))
     *     )
     * )
     *   @OA\Response(
     *     response="400",
     *     description="BAD REQUEST",

     *   ),
     * @OA\Response(
     *     response="401",
     *     description="UnAuthorised",

     *   ),
     * @OA\Response(
     *     response="404",
     *     description="Not Found",

     *   ),
     * @OA\Response(
     *     response="500",
     *     description="Internal Server Error",

     *   ),
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID number to be listed",
     *     example="42",
     *     @OA\Schema(schema="id",type="integer")
     * )
     * @OA\Tag(name="Asset Manager")
     * @Security(name="Bearer")    
     */
     
    // Preview API Controller function for Asset Preview 
    public function preview(int $id): Response
    {
        $response=new Response();
        try{
        $asset = $this->getDoctrine()->getRepository(AssetManagerMaster::class)->list_preview($id);
        if (!$asset) throw $this->createNotFoundException('No product found for id '.$id);
        return $this->json($asset);
        $response->setStatusCode( 200, 'Success' );
        }
        catch(\Error $e) {
            $response -> setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent(json_encode(['message' => 'errors', 'errors' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine(), 'trace' => $e->getTraceAsString()]));
        }
        return $response;
    }
}
