import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Injectable } from '@angular/core';
import{Assetlist} from './asset-list';
import { Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class AssetListService {

  constructor(private http:HttpClient) { }
  getAssetList(offset:number,field:string,order:string,limit:number):Observable<Assetlist[]>
   {
    return this.http.get<Assetlist[]>("http://localhost:8000/api/asset/list/?limit="+limit+"&offset="+offset+"&fieldName="+field+"&sorting="+order);
   }

}
