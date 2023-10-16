export const currencyFormatter = new Intl.NumberFormat(undefined, {
    currency: "usd",
    style: "currency",
    minimumFractionDigits: 0
})

export const getFormatedStringFromDays = (days) => {
    days = +days;
    if(Number.isInteger(+days)) {
        var years = Math.floor(days / 365);
        var year_text = years === 1 ? ' year ' : ' years ';
        days %= 365;
        var months = Math.floor(days / 30);
        var mon_text = months <= 1 ? ' month ' : ' months ';
        var days = days % 30;
        var day_text = days <= 1 ? ' day' : ' days';
        return '' + years === 0 ? years + year_text : + months + mon_text + days + day_text;
    } else {
        return 'not a number';
    }
}

export const formatDateV1 = (date) => {
    return new Date(date).toLocaleDateString()
}