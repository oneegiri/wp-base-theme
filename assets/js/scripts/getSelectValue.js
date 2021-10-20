//Returns the current selected value of a select
export default function getCurrentSelectedValue(e){
  return e.options[e.selectedIndex].text;
}