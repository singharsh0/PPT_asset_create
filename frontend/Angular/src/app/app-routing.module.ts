import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {AssetCreateComponent} from './asset-create/asset-create.component';
import { AssetListComponent } from './asset-list/asset-list.component';
import { AssetPreviewComponent } from './asset-preview/asset-preview.component';

const routes: Routes = [
  {path:'',redirectTo:'/asset-list',pathMatch:'full'},
  { path: 'asset-create', component: AssetCreateComponent },
  { path: 'asset-list', component: AssetListComponent },
  { path: 'asset-preview/:id',component:AssetPreviewComponent}
  
  
];


@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
