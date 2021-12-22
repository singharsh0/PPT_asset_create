import { Component, OnInit } from '@angular/core';
import {AssetService} from '../asset.service';
import { NgForm } from '@angular/forms';
import {FileUploadService} from '../fileupload.service';
import { UploadimageService } from '../uploadimage.service';
import { Router } from '@angular/router';
@Component({
  selector: 'app-asset-create',
  templateUrl: './asset-create.component.html',
  styleUrls: ['./asset-create.component.css']
})
export class AssetCreateComponent implements OnInit {
  selectedFile : File | null =null;
  pptFileName:string |null =null;
  imageFileName:string |null =null;
  shortLink: string = "";
  loading: boolean = false; // Flag variable
  file: any; // Variable to store file
  photoExtensions:Array<string>=['image/jpeg','image/png','image/jpg'];  //allowed photo formats
 fileextension:string='';
  constructor(private rest:FileUploadService,private restData:AssetService,private img:UploadimageService ,private router:Router) { }

  ngOnInit(): void {
  }
  onFileSelected(event:any)
  {
    this.file = event.target.files[0];
    this.pptFileName=this.file.name;
    // alert(this.pptFileName);
    let extension = null;

    extension = this.file.name.split('?')[0].split('.').pop();
    if (extension == 'ppt'||extension == 'pptx') {

    }
    else {
      // this.file_error="";
      alert("Please select correct extension file");
    }

    this.loading = !this.loading;
        //console.log(this.file);

        this.rest.upload(this.file).subscribe(
            (event: any) => {
                if (typeof (event) === 'object') {
  
                    // Short link via api response
                    this.shortLink = event.link;
  
                    this.loading = false; // Flag variable 
                }
            }
        );
  
  }
  photoFileSelected(event:any)
  {
    this.file = event.target.files[0];
    this.imageFileName=this.file.name;
    this.fileextension=this.file.type;
    console.log(this.fileextension);

    if(this.photoExtensions.includes(this.fileextension))
    {
    this.loading = !this.loading;
        console.log(this.file);
        console.log(this.imageFileName);
        this.img.upload(this.file).subscribe(
            (event: any) => {
                if (typeof (event) === 'object') {
  
                    // Short link via api response
                    this.shortLink = event.link;
  
                    this.loading = false; // Flag variable 
                }
            }
        );
      }
      else
      {
        this.imageFileName='';
      }   
  
  }
  
  saveasset(formdata:NgForm)
  {
    //console.log(formdata);
       this.restData.addasset(formdata).subscribe(data=>{
        alert(data);
        this.router.navigate(['/asset-list']);
     });
      
  }

}
