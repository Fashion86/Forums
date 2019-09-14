import { Routes } from '@angular/router';

import { FootballComponent } from './football/football.component';
import { CricketComponent } from './cricket/cricket.component';
import { TennisComponent } from './tennis/tennis.component';
import { RagbiComponent } from './ragbi/ragbi.component';

export const ForumRoutes: Routes = [
  {
    path: '',
    children: [
      {
        path: 'football',
        component: FootballComponent
      },
      {
        path: 'cricket',
        component: CricketComponent
      },
      {
        path: 'tennis',
        component: TennisComponent
      },
      {
        path: 'ragbi',
        component: RagbiComponent
      }
    ]
  }
];
