
export class Item {
  ITEM_ID: number;
  ID? = [];
  ORDER_NUM: number;
  QTY: number;
  TYPE_NAME: string;
  MODEL: string;
  MANUFACTURER: string;
  SERIAL_NUM: string;
  AGE: number;
  MILEAGE: number;
  CONDITION: string;
  CUSTOM1: string;
  CUSTOM2: string;
  CUSTOM3: string;
  UNIT1: string;
  UNIT2: string;
  UNIT3: string;
  ADDITIONAL_COMMENTS: string;
  GENERAL_APPRAISAL_COMMENTS: string;
  children? = [];
  comps? = [];
  serialNums? = [];
  DYNAMIC_1: string;
  DYNAMIC_2: string;
  fmv: number;
  flv: number;
  olv: number;
  ESTIMATEDLIFE: number;
  report_id: number;
}
