import {Injectable} from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { map } from 'rxjs/operators';
import {User} from '../models/user';
import * as Constants from '../app.const';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(private http: HttpClient) { }

  public authenticate(email: string, password: string) {
    return this.http
        .post(Constants.API_URL + '/api/auth/login', {
          email: email,
          password: password
        })
        .pipe(
            map((response: Response) => response)
        );
  }

  public signup(data) {
    return this.http
        .post(Constants.API_URL + '/api/register', data)
        .pipe(
            map((response: Response) => response)
        );
  }

  public forgot(email: string) {
    return this.http
        .post(Constants.API_URL + '/api/auth/forgotpasswd', {
          email: email
        })
        .pipe(
            map((response: Response) => response)
        );
  }

  public resetpasswd(password: string, token: string) {
    return this.http
        .post(Constants.API_URL + '/api/auth/resetPassword', {
          password: password, token: token
        })
        .pipe(
            map((response: Response) => response)
        );
  }
}

