import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UploadimageService {
  baseApiUrl = "http://localhost:8000/api/asset/create"
  constructor(private http:HttpClient){ }
  
  upload(file:File):Observable<any> {
  
    
    // Create form data
    let formData = new FormData(); 
      
    // Store form name as "file" with file data
    formData.append("file", file);
      
    // Make http post request over api
    // with formData as req
    return this.http.post(this.baseApiUrl, formData)
}
}