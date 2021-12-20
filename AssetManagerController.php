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
     * @Route("/api/asset/list/", name="asset_list",methods={"Get"})    
        */
    
    // List API Controller function for Listing asset details 
    public function showAll(Request $request): Response
    {
       $assets = $this->getDoctrine()
       ->getRepository(AssetManagerMaster::class)
       ->list_view($request);
       
       $total = $this->getDoctrine()->getRepository(AssetManagerMaster::class)->total();
        
        return $this->json(array('total'=>$total,'data'=>$assets));
     
     }   
     
    #[Route("/api/asset/preview/{id}", name:"asset_preview",methods:"GET")]
     
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
