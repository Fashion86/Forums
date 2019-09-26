import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {MatSnackBar, MatTableDataSource} from "@angular/material";
import {UsersService} from "../../services/users.service";
import {User} from "../../models/user";

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent implements OnInit {

  isSpinnerVisible = true;
  user: any;
  height = 300;
  constructor(private router: Router,
              private route: ActivatedRoute,
              private _usersService: UsersService,
              public snackBar: MatSnackBar) {

  }

  ngOnInit() {
    this.user = new User();
    this.height = window.innerHeight-140;
    this.route.params.subscribe(params => {
      if (params['id']) {
        this._usersService.getUserById(params['id'])
            .subscribe(res => {
              this.isSpinnerVisible = false;
              this.user = res['data'];
            }, error => {
              this.isSpinnerVisible = false;
              console.log('Error get topic', error);
            });
      } else {

      }
    });
  }

  goToTopic(data, id = null) {
    const link = '/forum/' + data.category_name + '/post';
    if (id) {
      this.router.navigate([link, {topic: id}]);
    } else {
      this.router.navigate([link, {topic: data.id}]);
    }
  }

}
