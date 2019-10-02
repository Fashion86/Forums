import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {PostService} from "../../services/post.service";
import {NgxSpinnerService} from "ngx-spinner";

@Component({
  selector: 'app-seach-result',
  templateUrl: './seach-result.component.html',
  styleUrls: ['./seach-result.component.css']
})
export class SeachResultComponent implements OnInit {

  constructor(private router: Router, private route: ActivatedRoute,
              private _postService: PostService,
              private spinner: NgxSpinnerService) { }

  ngOnInit() {
    this.route.queryParams.subscribe(params => {
      const param = {
        term: params['term'],
        type: params['type']
      };
      this.spinner.show();
      this._postService.getSearch(param)
          .subscribe(
              res => {
                this.spinner.hide();
                if (res['success']) {

                }
              }, error => {
                this.spinner.hide();
              });
    })
  }

}
