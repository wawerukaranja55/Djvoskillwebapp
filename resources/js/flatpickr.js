import flatpickr from "flatpickr";

flatpickr('#event_date',{
    enableTime:true,
    time_24hr:true,
    altInput:true,
    altFormat:'d M Y H:i',
    dateFormat:'Y-m-d H:i'
});