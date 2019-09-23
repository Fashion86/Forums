import { Routes } from '@angular/router';

import { FootballComponent } from './football/football.component';
import { CricketComponent } from './cricket/cricket.component';
import { TennisComponent } from './tennis/tennis.component';
import { RagbiComponent } from './ragbi/ragbi.component';
import { UsersComponent } from './users/users.component';
import { TopicComponent } from './topic/topic.component';
import { ContactUsComponent } from './contact-us/contact-us.component';
import { HomeComponent } from './home/home.component';
import { PostComponent } from './post/post.component';

export const ForumRoutes: Routes = [
  {
    path: '',
    children: [
      {
        path: '',
        component: HomeComponent,
        pathMatch: 'full'
      },
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
          },
          {
            path: 'post',
            component: PostComponent
          }
        ]
      },
      {
        path: 'cricket',
        children: [
          {
            path: '',
            component: CricketComponent
          },
          {
            path: 'topic',
            component: TopicComponent
          },
          {
            path: 'post',
            component: PostComponent
          }
        ]
      },
      {
        path: 'tennis',
        children: [
          {
            path: '',
            component: TennisComponent
          },
          {
            path: 'topic',
            component: TopicComponent
          },
          {
            path: 'post',
            component: PostComponent
          }
        ]
      },
      {
        path: 'rugby',
        children: [
          {
            path: '',
            component: RagbiComponent
          },
          {
            path: 'topic',
            component: TopicComponent
          },
          {
            path: 'post',
            component: PostComponent
          }
        ]
      },
      {
        path: 'contact-us',
        component: ContactUsComponent
      }
    ]
  }
];
