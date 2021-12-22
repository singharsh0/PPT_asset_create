import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import {FormsModule} from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AssetCreateComponent } from './asset-create/asset-create.component';
import {HttpClientModule} from '@angular/common/http';
import { AssetListComponent } from './asset-list/asset-list.component'
import { NgxPaginationModule } from 'ngx-pagination';
import { AssetPreviewComponent } from './asset-preview/asset-preview.component';
import { NgxDocViewerModule } from 'ngx-doc-viewer';
@NgModule({
  declarations: [
    AppComponent,
    AssetCreateComponent,
    AssetListComponent,
    AssetPreviewComponent,

  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    HttpClientModule,
    FormsModule,
    NgxPaginationModule,
    NgxDocViewerModule

  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
