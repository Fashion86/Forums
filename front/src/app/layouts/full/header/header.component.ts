import { Component } from '@angular/core';
import { PerfectScrollbarConfigInterface } from 'ngx-perfect-scrollbar';
import {Router} from '@angular/router';
import {AuthService} from "../../../services/auth.service";

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: []
})
export class AppHeaderComponent {
  public config: PerfectScrollbarConfigInterface = {};
  // This is for Notifications
  notifications: Object[] = [
    {
      round: 'round-danger',
      icon: 'ti-link',
      title: 'Launch Admin',
      subject: 'Just see the my new admin!',
      time: '9:30 AM'
    },
    {
      round: 'round-success',
      icon: 'ti-calendar',
      title: 'Event today',
      subject: 'Just a reminder that you have event',
      time: '9:10 AM'
    },
    {
      round: 'round-info',
      icon: 'ti-settings',
      title: 'Settings',
      subject: 'You can customize this template as you want',
      time: '9:08 AM'
    },
    {
      round: 'round-primary',
      icon: 'ti-user',
      title: 'Pavan kumar',
      subject: 'Just see the my admin!',
      time: '9:00 AM'
    }
  ];

  user: any;
  constructor(
      private router: Router, private _authService: AuthService
  ) {
    this.user = JSON.parse(localStorage.getItem('profile'));
    // this.user.role.forEach(role => {
    //   if (role.name === 'ROLE_ADMIN') {
    //     this.isadmin = true;
    //   }
    // });
  }

  onLogin() {
    this.router.navigate(['/authentication/login']);
  }

  onContactUs() {
    this.router.navigate(['/forum/contact-us']);
  }

  logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('profile');
    window.location.reload();
    // this.user = JSON.parse(localStorage.getItem('profile'));
    // this._authService.logout()
    //     .subscribe(
    //         data => {
    //           localStorage.removeItem('token');
    //           localStorage.removeItem('profile');
    //           this.user = null;
    //         },
    //         error => {
    //
    //         });
  }
}
