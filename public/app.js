setTimeout(() => {
    if (document.querySelector(".success-alert-box")) {
        setTimeout(() => {
            document.querySelector(".success-alert-box").style.visibility = "hidden"; 
          }, "1000")
    }
}, "1000")





function getTimeFromTimezone(timezone) {
    // Create a DateTimeFormat object with the specified timezone
    // console.log(timezone);
    const dateTimeFormat = new Intl.DateTimeFormat('en-GB', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        timeZone: timezone,
        timeZoneName: 'short'
    });
    
    // Create a Date object for the current date and time
    const date = new Date();
    
    // Use the DateTimeFormat object to format the Date object
    const formattedDate = dateTimeFormat.format(date);

    let str1 = formattedDate.slice(0, 8)
    let arr1 = str1.split(':');
    let arr2 = ["0", "0", "0"];
    if (23 - parseInt(arr1[0]) < 10) {
        arr2[0] = "0" + (23 - parseInt(arr1[0]));
    } else arr2[0] = String(23 - parseInt(arr1[0]));
    if (59 - parseInt(arr1[1]) < 10) {
        arr2[1] = "0" + (59 - parseInt(arr1[1]));
    } else arr2[1] = String(59 - parseInt(arr1[1]));
    if (59 - parseInt(arr1[2]) < 10) {
        arr2[2] = "0" + (59 - parseInt(arr1[2]));
    } else arr2[2] = String(59 - parseInt(arr1[2]));
    let str2 = arr2[0] + ":" + arr2[1] + ":" + arr2[2]

    // console.log(str1);
    
    // Return the formatted date and time
    // return formattedDate;

    document.querySelector(".timeleft").innerHTML = str2;
}

fetch('/api/timezone')
.then(response => response.text())
.then(data => {
    let timezone = data;
    getTimeFromTimezone(timezone);
    setInterval(function() {
        getTimeFromTimezone(timezone);
    }, 1000);
});

