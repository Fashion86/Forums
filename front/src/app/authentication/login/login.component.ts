import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import {
  FormBuilder,
  FormGroup,
  Validators,
  FormControl
} from '@angular/forms';
import {AuthService} from '../../services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  public form: FormGroup;
  constructor(private fb: FormBuilder, private router: Router, private _authService: AuthService) {}

  ngOnInit() {
    this.form = this.fb.group({
      uname: [null, Validators.compose([Validators.required])],
      password: [null, Validators.compose([Validators.required])]
    });
  }

  onSubmit() {
    this._authService.authenticate(this.form.value.uname, this.form.value.password)
        .subscribe(
            data => {
              if (data['success']) {
                localStorage.setItem('token', data['result'].token);
                localStorage.setItem('profile', JSON.stringify(data['result'].profile));
              } else {
                // if (data['errors'][0].code === 400) {
                //   this.errorStr = 'Wrong email or password';
                // }
                // let errlist = [];
                // if (data['errors'][0].code === 3 && data['errors'][0].txt) {
                //   errlist = data['errors'][0].txt.split(':');
                //   this.errorStr = errlist[errlist.length - 1];
                // }
                // this.errorMessage = true;
              }
            });
  }
}
