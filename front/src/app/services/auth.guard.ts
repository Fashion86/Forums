import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';

@Injectable()
export class AuthGuard implements CanActivate {
    constructor(private router: Router) {}

    canActivate() {
        // console.log(localStorage.getItem('token'));
        if (localStorage.getItem('token')) {
            return true;
        }

        this.router.navigate(['/forum']);
        return false;
    }
}
