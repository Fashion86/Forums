import { Component, OnInit, ViewChild } from '@angular/core';
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, FormArray, Validators, FormControl} from "@angular/forms";
import {MatChipInputEvent, MatChipList, MatSnackBar} from "@angular/material";
import {COMMA, ENTER} from "@angular/cdk/keycodes";
import {PostService} from "../../services/post.service";

@Component({
  selector: 'app-topic',
  templateUrl: './topic.component.html',
  styleUrls: ['./topic.component.css']
})
export class TopicComponent implements OnInit {

  user: any;
  tagFormGroup: FormGroup;
  separatorKeysCodes = [ENTER, COMMA];
  tags =  {
    names: ['name1', 'name2']
  };
  visible = true;
  selectable = true;
  removable = true;
  addOnBlur = true;
  category = null;
  @ViewChild('chipList') chipList: MatChipList;
  constructor(private router: Router, private _formBuilder: FormBuilder,
              private _postService: PostService,
              public snackBar: MatSnackBar) { }

  ngOnInit() {
    if (this.router.url === '/forum/football/topic') {
      this.category = 'football';
    } else if (this.router.url === '/forum/cricket/topic') {
      this.category = 'cricket';
    } else if (this.router.url === '/forum/tennis/topic') {
      this.category = 'tennis';
    } else if (this.router.url === '/forum/rugby/topic') {
      this.category = 'rugby';
    }
    this.user = JSON.parse(localStorage.getItem('profile'));
    if (!this.user) {
      this.router.navigate(['/authentication/login']);
    }
    this.tagFormGroup = this._formBuilder.group({
      tags: this._formBuilder.array(this.tags.names, this.validateArrayNotEmpty),
      title: [null, Validators.compose([Validators.required])],
      content: [null, Validators.compose([Validators.required, Validators.minLength(30)])]
    });
    this.tagFormGroup.get('tags').statusChanges.subscribe(
        status => this.chipList.errorState = status === 'INVALID'
    );
  }

  validateArrayNotEmpty(c: FormControl) {
    if (c.value && c.value.length === 0) {
      return {
        validateArrayNotEmpty: { valid: false }
      };
    }
    return null;
  }

  initName(name: string): FormControl {
    return this._formBuilder.control(name);
  }

  add(event: MatChipInputEvent, form: FormGroup): void {
    const input = event.input;
    const value = event.value;

    // Add name
    if ((value || '').trim()) {
      const control = <FormArray>form.get('tags');
      control.push(this.initName(value.trim()));
    }

    // Reset the input value
    if (input) {
      input.value = '';
    }
  }

  remove(form, index) {
    form.get('tags').removeAt(index);
  }

  onSubmit() {
    const formdata = {
      category: this.category,
      tags: this.tagFormGroup.controls['tags'].value,
      title: this.tagFormGroup.controls['title'].value,
      content: this.tagFormGroup.controls['content'].value
    };
    this._postService.addTopic(formdata)
        .subscribe(
            data => {
              this.snackBar.open('Success Deleted!', 'Close', {
                duration: 5000,
                panelClass: 'blue-snackbar'
              });
            }, error => {
              this.snackBar.open('Error Delete!', 'Close', {
                duration: 5000,
                panelClass: 'blue-snackbar'
              });
            });
  }
}
