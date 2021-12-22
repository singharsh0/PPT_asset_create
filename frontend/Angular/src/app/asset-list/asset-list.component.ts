import { Component, OnInit } from '@angular/core';
import {Assetlist} from '../asset-list';
import {AssetListService} from '../asset-list.service';
@Component({
  selector: 'app-asset-list',
  templateUrl: './asset-list.component.html',
  styleUrls: ['./asset-list.component.css']
})
export class AssetListComponent implements OnInit {
  asset: any | Assetlist[];
pageNumber:number=0;
sortOrder:boolean=true;  //understand state for sorting
order:string='desc';      //sorting order
fieldName:string='id';
totalRecord:Number=30;
numb:Array<number>=new Array(5);
limit:number=10;


  constructor(private rest:AssetListService) { }

  ngOnInit(): void {
    console.log(this.numb);
   this.getassets();
  }

  page(i:number):void {
    //console.log(i);
    this.pageNumber=i;
    this.getassets();
    }

    field(f:string):void {
     // console.log(f);
     (this.sortOrder)?this.sortOrder=false:this.sortOrder=true; //set states on click
     (this.sortOrder)?this.order='asc':this.order='desc'; // set sort order
     console.log(this.sortOrder);
      this.fieldName=f;
      this.getassets();
      }

 getassets():void{
  {
    this.rest.getAssetList(this.pageNumber,this.fieldName,this.order,this.limit).subscribe(
      (response:Assetlist[])=>{ this.asset=response;}
    );
  }
 }
 


}
  
  

