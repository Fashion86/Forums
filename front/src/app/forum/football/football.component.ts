import { Component, OnInit, ViewChild } from '@angular/core';
import { MatSort, MatTableDataSource} from '@angular/material';
import {Router, ActivatedRoute, RoutesRecognized, NavigationEnd } from '@angular/router';
import { filter, pairwise } from 'rxjs/operators';

@Component({
  selector: 'app-football',
  templateUrl: './football.component.html',
  styleUrls: ['./football.component.scss']
})
export class FootballComponent implements OnInit {

  forums: any[];
  columns = [{ prop: 'title' }, { name: 'content' }];
  totalCount: number;
  pageIndex: number;
  pageSize: number;
  dataSource: MatTableDataSource<any> = new MatTableDataSource<any>();
  displayedColumns = ['title', 'author', 'posts', 'content'];
  @ViewChild(MatSort) sort: MatSort;
  constructor(private router: Router, private route: ActivatedRoute) {
    this.forums = [{title: 'Hi! it is test problem', content: 'this is test1'}, {title: 'test3', content: 'this is test3'},
        {title: 'Hi! it is second test problem', content: 'this is test1 polpolpol!!!'}, {title: 'test5', content: 'this is test1'}];
  }

  ngOnInit() {
    // this.router.events
    //     .pipe(filter((e: any) => e instanceof NavigationEnd),
    //         pairwise()
    //     ).subscribe((e: any) => {
    //   console.log('ddd', e[0].urlAfterRedirects); // previous url
    // });

    this.dataSource.data = this.forums;
  }
  setPage(event) {
      this.pageIndex = event.pageIndex;
      this.pageSize = event.pageSize;
      this.setPageData(this.pageIndex, this.pageSize);
  }

  setPageData(pageIndex, pageSize) {
      // this.reports = _.sortBy(this.reports, ['reportDate', 'asc']); // Sort by reportDate
      // this.forums = _.orderBy(this.reports, [this.sortName], [this.sortDirection]);
      this.dataSource.data = this.forums.slice(pageIndex * pageSize, pageIndex * pageSize + pageSize);
  }

  onRate(event) {

  }

  onCreateTopic() {
    this.router.navigate(['/forum/football/topic']);
  }
}
