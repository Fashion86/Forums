import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  forums: any[] = [];
  football_forums: any[];
  criket_forums: any[];
  tennis_forums: any[];
  rugby_forums: any[];
  constructor() {

  }

  ngOnInit() {
  }

}
