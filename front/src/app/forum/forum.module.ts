import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import {
    MatIconModule,
    MatCardModule,
    MatInputModule,
    MatCheckboxModule,
    MatButtonModule
} from '@angular/material';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { FlexLayoutModule } from '@angular/flex-layout';
import { RatingModule } from 'ng-starrating';

import { ForumRoutes } from './forum.routing';

import { FootballComponent } from './football/football.component';
import { CricketComponent } from './cricket/cricket.component';
import { TennisComponent } from './tennis/tennis.component';
import { RagbiComponent } from './ragbi/ragbi.component';
import { DemoMaterialModule } from '../demo-material-module';
import { NgxDatatableModule } from '@swimlane/ngx-datatable';

@NgModule({
  declarations: [FootballComponent, CricketComponent, TennisComponent, RagbiComponent],
  imports: [
      CommonModule,
      RouterModule.forChild(ForumRoutes),
      MatIconModule,
      MatCardModule,
      MatInputModule,
      MatCheckboxModule,
      MatButtonModule,
      FlexLayoutModule,
      FormsModule,
      ReactiveFormsModule,
      DemoMaterialModule,
      NgxDatatableModule,
      RatingModule
  ]
})
export class ForumModule { }
