import { Routes } from '@angular/router';

import { FootballComponent } from './football/football.component';
import { CricketComponent } from './cricket/cricket.component';
import { TennisComponent } from './tennis/tennis.component';
import { RagbiComponent } from './ragbi/ragbi.component';
import { UsersComponent } from './users/users.component';
import { TopicComponent } from './topic/topic.component';

export const ForumRoutes: Routes = [
  {
    path: '',
    children: [
      {
        path: 'users',
        component: UsersComponent
      },
      {
        path: 'football',
        children: [
          {
            path: '',
            component: FootballComponent
          },
          {
            path: 'topic',
            component: TopicComponent
          }
        ]
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
      },
      {
        path: 'topic',
        component: TopicComponent
      }
    ]
  }
];
