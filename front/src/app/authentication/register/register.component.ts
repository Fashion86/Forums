import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import {
  FormBuilder,
  FormGroup,
  Validators,
  FormControl
} from '@angular/forms';
import { CustomValidators } from 'ng2-validation';
import {AuthService} from "../../services/auth.service";

const password = new FormControl('', [Validators.required]);
const confirmPassword = new FormControl('', CustomValidators.equalTo(password));

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  public form: FormGroup;
  errorStr = null;
  constructor(private fb: FormBuilder, private router: Router, private _authService: AuthService) {}

  ngOnInit() {
    this.errorStr = null;
    this.form = this.fb.group({
      username: [
        null,
        Validators.compose([Validators.required])
      ],
      email: [
        null,
        Validators.compose([Validators.required, CustomValidators.email])
      ],
      password: password,
      confirmPassword: confirmPassword
    });
    this.form.valueChanges.subscribe( (data) => {
      this.errorStr = null;
    });
  }

  onSubmit() {
    const postdata = {
      username: this.form.value.username,
      email: this.form.value.email,
      password: this.form.value.password};
    this._authService.signup(postdata)
        .subscribe(
            data => {
                  if (data['success']) {
                    this.router.navigate(['/forum']);
                  } else {

                  }
                },
            error => {
              const err = error['error'];
              if (err && err['error']) {
                for (let key in err['error']) {
                  if (err['error'].hasOwnProperty(key)) {
                      this.errorStr = key + " -> " + err['error'][key][0];
                      break;
                  }
                }
              }
            });
  }
}
