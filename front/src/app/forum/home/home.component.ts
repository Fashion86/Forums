import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  forums: any[];
  constructor() {
    this.forums = [{title: 'Hi! it is test problem', content: 'this is test1'}, {title: 'test3', content: 'this is test3'},
      {title: 'Hi! it is second test problem', content: 'this is test1 polpolpol!!!'}, {title: 'test5', content: 'this is test1'}];
  }

  ngOnInit() {
  }

}
