import { Injectable } from '@angular/core';
import * as Constants from "../app.const";
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {map} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class PostService {

  constructor(private http: HttpClient) { }

  public getTopics(category) {
    return this.http
        .get(Constants.API_URL + '/api/topics/' + category)
        .pipe(
            map((response: Response) => response)
        );
  }

  public getTopic(id) {
    return this.http
        .get(Constants.API_URL + '/api/topic/' + id)
        .pipe(
            map((response: Response) => response)
        );
  }

  public addTopic(data) {
    return this.http
        .post(Constants.API_URL + '/api/topic', data, this.jwt())
        .pipe(
            map((response: Response) => response)
        );
  }

  public addPost(data) {
    return this.http
        .post(Constants.API_URL + '/api/post', data, this.jwt())
        .pipe(
            map((response: Response) => response)
        );
  }

  delTopic(topicId) {
    return this.http
        .delete(Constants.API_URL + '/api/topic/' + topicId, this.jwt())
        .pipe(
            map((response: Response) => response)
        );
  }
  private jwt() {
    if (localStorage.getItem("token")) {
      const headers = new HttpHeaders().set("Authorization", "Bearer " + localStorage.getItem("token"));
      return {headers: headers};
    }
  }
}