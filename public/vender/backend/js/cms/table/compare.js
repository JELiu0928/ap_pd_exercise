export function dateCompare(filterLocalDateAtMidnight, cellValue) {
    const dateAsString = cellValue;
    if (dateAsString == null) return -1;
    // In the example application, dates are stored as dd/mm/yyyy
    // We create a Date object for comparison against the filter date
    const dateParts = dateAsString.split(/[\-T]+/);
    console.log(dateParts);
    const year = Number(dateParts[0]);
    const month = Number(dateParts[1]) - 1;
    const day = Number(dateParts[2]);
    const cellDate = new Date(year, month, day);

    if (filterLocalDateAtMidnight.getTime() === cellDate.getTime()) {
        return 0;
    } else if
        // Now that both parameters are Date objects, we can compare
        (cellDate < filterLocalDateAtMidnight) {
        return -1;
    } else if (cellDate > filterLocalDateAtMidnight) {
        return 1;
    }
    return 0;
}