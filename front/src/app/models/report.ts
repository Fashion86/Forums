import {Item} from "./item";
import {User} from "./user";

export class Report {
  REPORT_ID: number;
  USER: User;

  COMPANY_NAME: string;
  COMPANY_ADDRESS1: string;
  COMPANY_ADDRESS2: string;
  COMPANY_CITY: string;
  COMPANY_STATE: string;
  COMPANY_ZIP: string;

  // Company Contact
  COMPANY_CONTACT_FIRST_NAME: string;
  COMPANY_CONTACT_LAST_NAME: string;
  COMPANY_CONTACT_PHONE: string;
  COMPANY_CONTACT_EMAIL: string;

  // Client
  CLIENT_COMPANY_NAME: string;
  CLIENT_CONTACT_FIRST_NAME: string;
  CLIENT_CONTACT_LAST_NAME: string;
  CLIENT_CONTACT_ZIP: string;
  CLIENT_CONTACT_ADDRESS1: string;
  CLIENT_CONTACT_ADDRESS2: string;
  CLIENT_CONTACT_CITY: string;
  CLIENT_CONTACT_STATE: string;
  CLIENT_CONTACT_PHONE: string;
  CLIENT_CONTACT_EMAIL: string;
  CREATED_DATE: Date;
  UPDATED_DATE: Date;

  items: Array<Item>;
}
