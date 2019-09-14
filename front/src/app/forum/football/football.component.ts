import { Component, OnInit, ViewChild } from '@angular/core';
import { MatSort, MatTableDataSource} from '@angular/material';

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
  displayedColumns = ['title', 'content'];
  @ViewChild(MatSort) sort: MatSort;
  constructor() {
    this.forums = [{title: 'test', content: 'this is test1'}, {title: 'test3', content: 'this is test3'},
        {title: 'test4', content: 'this is test1'}, {title: 'test5', content: 'this is test1'}];
  }

  ngOnInit() {
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
}
