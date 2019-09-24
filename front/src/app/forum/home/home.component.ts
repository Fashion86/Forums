import { Component, OnInit } from '@angular/core';
import {MatSnackBar, MatTableDataSource} from "@angular/material";
import {ActivatedRoute, Router} from "@angular/router";
import {PostService} from "../../services/post.service";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  isSpinnerVisible = true;
  big_posts_forums: any[] = [];
  football_forums: any[] = [];
  criket_forums: any[] = [];
  tennis_forums: any[] = [];
  rugby_forums: any[] = [];
  constructor(private router: Router, private route: ActivatedRoute,
              private _postService: PostService,
              public snackBar: MatSnackBar
              ) {

  }

  private getLatestTopics(): void {
    this._postService.getLatestTopics()
        .subscribe(res => {
          this.isSpinnerVisible = false;
          if (res['success']) {
            this.football_forums = res['football'];
            this.criket_forums = res['cricket'];
            this.tennis_forums = res['tennis'];
            this.rugby_forums = res['rugby'];
            this.big_posts_forums = res['big'];
          }

        }, error => {
          this.isSpinnerVisible = false;
          console.log('Error get topics', error);
        });
  }

  ngOnInit() {
    this.getLatestTopics();
  }

}
