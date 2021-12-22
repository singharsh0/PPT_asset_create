import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';


@Component({
  selector: 'app-asset-preview',
  templateUrl: './asset-preview.component.html',
  styleUrls: ['./asset-preview.component.css']
})
export class AssetPreviewComponent implements OnInit {
userid:any;
maindata:any;
src1:string='';
src2:string='';
imgurl:string='http://localhost:8000/public/upload/permanent/';
pptsrc:string='http://localhost/training/permanent/';
abc:string=`https://docs.google.com/viewer?url=${encodeURIComponent(`https://courses.engr.illinois.edu/cs425/fa2014/L2.fa14.ppt`)}&embedded=true`;
  url1:SafeResourceUrl=this.domSanitizer.bypassSecurityTrustResourceUrl(this.abc);

  constructor(private route:ActivatedRoute,private http:HttpClient,private domSanitizer:DomSanitizer) { }

  ngOnInit(): void {
    let id=this.route.snapshot.params['id']
    this.userid=id;
    let url =`http://localhost:8000/api/asset/preview/${this.userid}`
    console.log(url)
    this.http.get(url).subscribe((data)=>{this.maindata=data;
      this.src1=this.imgurl+this.maindata[0].cover_image_file_name;
      this.src2=this.pptsrc+this.maindata[0].file_name;
      console.log(this.maindata);
      
     console.log(this.maindata);

    })
  }
  

}
