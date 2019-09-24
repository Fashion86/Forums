export class User {
  id: number;
  username: string;
  email: string;
  is_activated: number;
  is_activated_article: boolean;
  avatar_path: string;
  join_time: Date;
  last_seen_time: Date;
  read_time: Date;
  notification_read_time: Date;
  password: string;
  discussions_count: number;
  comments_count: number;
  role: string;
  created_at: any;
  updated_at: any;
}