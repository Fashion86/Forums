import { Component, OnInit } from '@angular/core';
import {User} from "../../../models/user";
import {NgxSpinnerService} from "ngx-spinner";
import {UsersService} from "../../../services/users.service";
import {MatSnackBar} from "@angular/material";
import {ActivatedRoute, Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CustomValidators} from "ng2-validation";

@Component({
  selector: 'app-my-profile',
  templateUrl: './my-profile.component.html',
  styleUrls: ['./my-profile.component.scss']
})
export class MyProfileComponent implements OnInit {

  public form: FormGroup;
  user: User;
  height = 300;
  constructor(private router: Router,
              private fb: FormBuilder,
              private route: ActivatedRoute,
              private _usersService: UsersService,
              private spinner: NgxSpinnerService,
              public snackBar: MatSnackBar) {


  }

  ngOnInit() {
    this.user = JSON.parse(localStorage.getItem('profile'));
    this.height = window.innerHeight-140;
    this.initForm();
  }
  initForm() {
    this.form = this.fb.group({
      username: [this.user.username, Validators.compose([Validators.required])],
      email: [this.user.email, Validators.compose([Validators.required, CustomValidators.email])],
    });
  }

  onSubmit() {
    this.spinner.show();
    this._usersService.updateUser({id: this.user.id, email: this.form.value.email, username: this.form.value.username})
        .subscribe(
            data => {
              this.spinner.hide();
              if (data['success']) {
                localStorage.setItem('profile', JSON.stringify(data['user']));
                this._usersService.setUser(data['user']);
              } else {

              }
            },
            error => {
              // const err = error['error'];
              this.spinner.hide();
            });
  }

}
