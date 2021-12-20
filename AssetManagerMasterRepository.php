<?php

namespace App\Repository;

use App\Entity\AssetManagerMaster;
use App\Entity\AssetManagerFileDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\Environment\Console;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method AssetManagerMaster|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssetManagerMaster|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssetManagerMaster[]    findAll()
 * @method AssetManagerMaster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method AssetManagerMaster[]    demo()
 */
$logger=new Logger("Asset Repository");

class AssetManagerMasterRepository extends ServiceEntityRepository
{    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssetManagerMaster::class);
    }
   
    /**
     * @return AssetManagerMaster[]
     */

    //API repository for list page
    public function list_view(Request $request): array
    {
        $limit=$request->query->get('limit');
       $offset=$request->query->get('offset');
        $fieldName=$request->query->get('fieldName');
        $sorting=$request->query->get('sorting');
        $entityManager = $this->getEntityManager();

        //Query for calling list data from database
        $query = $entityManager->createQueryBuilder('p')    
            ->SELECT ('p.id,p.name,p.description,p.steward,p.effective_date,p.identifier')
            ->FROM ('App\Entity\AssetManagerMaster', 'p')
          
        ->orderBy('p.'.$fieldName, $sorting)
        ->setMaxResults($limit)
        ->setFirstResult($offset*2)
        ->getQuery();

        return $query->getResult();
    }
    /**
     * @return AssetManagerMaster[]
     */
    public function total(): string
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQueryBuilder('p')    
            ->SELECT ('count(p.id) as total')
            ->FROM ('App\Entity\AssetManagerMaster', 'p')
          
        ->getQuery();

        $total_count=$query->getResult();
        return $total_count[0]['total'];
    }
    /**
     * @return AssetManagerMaster[]
     */

    //API repository function for Create Asset 
    public function create_asset($validator,$request,string $temp,string $permanent,string $directory,array $ppt_extension,array $img_extension,$logger)
    {
        //For file & image upload 
        if(isset($_FILES['file'])){
            $errors= "";
            $file_name = $_FILES['file']['name'];
            $file_type=$_FILES['file']['type'];
            $file_size =$_FILES['file']['size'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $temp=explode('.',$_FILES['file']['name']);
            $file_ext=strtolower(end($temp));
       
            $response = new Response(); 
            //Condition for checking whether file is PPT or not if file if ppt 
            //then upload the file in temp directory with status code (200)
            if($file_ext=="pptx"||$file_ext=="ppt")
            {   
            try{
                    {
                        move_uploaded_file($file_tmp,$directory.$file_name);
                        $response->setStatusCode( 200, 'Success' );
                    }
                }catch(\Error $e) {
                    $response->setStatusCode(400);
                    $response->setContent(json_encode(['message' => 'errors', 'errors' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine(), 'trace' => $e->getTraceAsString()]));
                }
                return $response;
                $logger->info('PPT file uploaded');
            //If file is img validating via extension then upload in temp folder with status code (200)
            }elseif(in_array($file_ext,$img_extension)=== true){
            try{   
                    {
                        move_uploaded_file($file_tmp,$directory.$file_name);
                        $response->setStatusCode( 200, 'Success' );                     
                    }
                }
                catch(\Error $e) {
                    $response->setStatusCode(400);
                    $response->setContent(json_encode(['message' => 'errors', 'errors' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine(), 'trace' => $e->getTraceAsString()]));
                }
                $logger->info('Image file uploaded');

            }//If file is neither ppt nor img then throw and error Extension not allowed with status code (500)
            else{
                
                    $errors="Extension not allowed.";
                    $response->setStatusCode( 500, 'Not Successful' );
                    $response->setContent(json_encode(['message' => 'errors', 'errors' => $errors ]));  
                    $logger->error('Files not uploading');
                }
            
            return $response;
        }
        //Requesting json content from frontend with asset data
        $parameters = json_decode($request->getContent(), true);
        $entityManager = $this->getEntityManager();

        //setting entity class AssetManagerMaster as $asset
        $asset = new AssetManagerMaster();

        //setting entity class AssetManagerFileDetails as $file
        $file = new AssetManagerFileDetails(); 
        $image_name=$parameters['cover_image_name'];
        $image_name=str_replace("\v","v",$image_name);
        $image_name=str_replace("\t","t",$image_name);
        $image_name=str_replace("\r","r",$image_name);
        $image_name=str_replace("\n","n",$image_name);
        $image_name=str_replace("\f","f",$image_name);
        $image_name=str_replace("\e","e",$image_name);
        $image_name=str_replace("\\","",$image_name);
        $image_name=str_replace("C:fakepath","",$image_name);
        $file_name=$parameters['file_name'];
        $file_name=str_replace("\v","v",$file_name);
        $file_name=str_replace("\t","t",$file_name);
        $file_name=str_replace("\r","r",$file_name);
        $file_name=str_replace("\n","n",$file_name);
        $file_name=str_replace("\f","f",$file_name);
        $file_name=str_replace("\e","e",$file_name);
        $file_name=str_replace("\\","",$file_name);
        $file_name=str_replace("C:fakepath","",$file_name);

    try{
            //setting asset values
            $asset->setName($parameters['name']);
            $asset->setDescription($parameters['description']);
            $asset->setEffectiveDate(new \DateTime($parameters['effective_date']));
            $asset->setExpirationDate(new \DateTime($parameters['expire_date']));
            $asset->setCreatedDate(new \DateTime());        
            $asset->setSteward($parameters['steward']);  
            $asset->setIdentifier($parameters['identifier']);  
            
            $file1_val=in_array(strtolower(substr($file_name,-4)),$ppt_extension);
            $file_val=in_array(strtolower(substr($file_name,-3)),$ppt_extension);
            
            //checking whether the correct image and file are set or not
            if($file_val===true || $file1_val===true)
            {
                //For uploading the Asset data in database
                $entityManager->persist($asset);
                $entityManager->flush();
                $logger->info('Parameters setting in master table');

                $file->setCoverImageFileName($image_name);
                $file->setFileName($file_name);
                $file->setCreatedDate(new \DateTime);
                $file->setLanguage($parameters['language']);

                //condition for checking empty string
                if (empty($parameters['name']) || empty($parameters['description']) || 
                empty($parameters['effective_date']) || empty($parameters['expire_date'])|| 
                empty($parameters['steward']) || empty($parameters['identifier'])|| 
                empty($parameters['language'])) 
                {throw new NotFoundHttpException('Expecting mandatory parameters!');}
                
                //For uploading the Asset data in database
                $entityManager->persist($file);
                $entityManager->flush();

                $file->setAssetId($asset->getId());
                $entityManager->flush();
                $logger->info('Parameters setting in file detail table');
            
            }
        //If correct image and file are not set then throw an error to upload correct correct extension file
        else{$error="Please select correct files";}
            $errors = $validator->validate($asset);
            $response = new Response(); 

            //Validating Asset
            if (empty($error)==false || count($errors)>0)
            {   $logger->error('Worng file extension.');
                return new Response($error);    }
            else{ 
                    //Moving file from temp to permanent
                    $sourceDirFile=$temp.$file_name; 
                    $targetDirFile=$permanent.$file_name;
                    $logger->info('File moving from temp to permanent');
                    if (rename($sourceDirFile, $targetDirFile)) {
                        
                        //moving image from temp to permanent
                        $sourceDirFile=$temp.$image_name;
                        $targetDirFile=$permanent.$image_name;
                        if (rename($sourceDirFile, $targetDirFile))
                        $logger->info('Image moving from temp to permanent');

                            //returning success status
                            return new Response("Successfully Added!");
                    } 
                } 
        }catch(\Error $e) {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                $response->setContent(json_encode(['message' => 'errors', 'errors' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine(), 'trace' => $e->getTraceAsString()]));
                return $response;
            }   
            
    }
    /**
     * @return AssetManagerMaster[]
     */

     //API repository for Asset preview
    public function list_preview(int $id): array
    {
        
        $entityManager = $this->getEntityManager();

        // Query for returning
        $query = $entityManager->createQueryBuilder('p')    
            ->SELECT ('p.asset_id ,r.name,p.file_name,p.cover_image_file_name,p.language')
            ->FROM ('App\Entity\AssetManagerFileDetails', 'p')
            ->Join('App\Entity\AssetManagerMaster', 'r')
            ->Where('p.asset_id = r.id')
            ->ANDWhere('p.asset_id = :id')
            ->setParameter('id', $id)
        ->getQuery();
        $output=$query->getResult();
        return $output;
    }
}
