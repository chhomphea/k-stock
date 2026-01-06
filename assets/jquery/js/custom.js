function dislayImage(n) {
    if (n !== null && n !== '') {
        var imgPath = base_url + 'assets/uploads/thumbs/' + n;
        var fullPath = base_url + 'assets/uploads/' + n;
        
        return '<img src="' + imgPath + '" ' +
               'data-full="' + fullPath + '" ' + 
               'class="product-img" ' + 
               'data-bs-toggle="tooltip" ' + 
               'title="Click to preview">';
    } 
    else {
        return '<img src="https://placehold.co/400x400/093967/ffffff?text=No+Img" ' +
               'class="product-img" ' + 
               'style="cursor: default;" ' + 
               'title="No Image">';
    }
}
function Active(n) {
    if (n == 1) {
        return '<span class="badge badge-status-active">Active</span>';
    } else if (n == 0) {
        return '<span class="badge badge-status-inactive">Inactive</span>';
    }
    return '';
}
function status(n) {
    if (n == "pending") {
        return '<div class="text-center"><span class="btn btn-warning btn-sm">Pending</span></div>';
    } else if (n == 0) {
        return '<div class="text-center"><span class="btn btn-danger btn-sm">Inactive</span></div>';
    } else if (n == "paid") {
        return '<div class="text-center"><span class="btn btn-success btn-sm">Paid</span></div>';
    } else if (n == "unpaid") {
        return '<div class="text-center"><span class="btn btn-danger btn-sm">Unpaid</span></div>';
    } else if (n == "partial") {
        return '<div class="text-center"><span class="btn btn-primary btn-sm">Partial</span></div>';
    }else if (n == "checked_out") {
        return '<div class="text-center"><span class="btn btn-danger btn-sm">Checked Out</span></div>';
    }
    return '';
}

function dateTime(date) {
    return date !== null ? date('d/m/Y', strtotime(date)) : date;
}
function date(A, t) {
    function e(A, t) {
        return r[A] ? r[A]() : t;
    }
    function n(A, t) {
        for (A = String(A); A.length < t;) A = "0" + A;
        return A;
    }
    var i, r, o = ["Sun", "Mon", "Tues", "Wednes", "Thurs", "Fri", "Satur", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        a = /\\?(.?)/gi;
    r = {
        d: function() { return n(r.j(), 2); },
        D: function() { return r.l().slice(0, 3); },
        j: function() { return i.getDate(); },
        l: function() { return o[r.w()] + "day"; },
        N: function() { return r.w() || 7; },
        S: function() {
            var A = r.j(), t = A % 10;
            return t <= 3 && 1 == parseInt(A % 100 / 10, 10) && (t = 0), ["st", "nd", "rd"][t - 1] || "th";
        },
        w: function() { return i.getDay(); },
        z: function() {
            var A = new Date(r.Y(), r.n() - 1, r.j()),
                t = new Date(r.Y(), 0, 1);
            return Math.round((A - t) / 864e5);
        },
        W: function() {
            var A = new Date(r.Y(), r.n() - 1, r.j() - r.N() + 3),
                t = new Date(A.getFullYear(), 0, 4);
            return n(1 + Math.round((A - t) / 864e5 / 7), 2);
        },
        F: function() { return o[6 + r.n()]; },
        m: function() { return n(r.n(), 2); },
        M: function() { return r.F().slice(0, 3); },
        n: function() { return i.getMonth() + 1; },
        t: function() { return new Date(r.Y(), r.n(), 0).getDate(); },
        L: function() {
            var A = r.Y();
            return A % 4 == 0 & A % 100 != 0 | A % 400 == 0;
        },
        o: function() {
            var A = r.n(), t = r.W();
            return r.Y() + (12 === A && t < 9 ? 1 : 1 === A && 9 < t ? -1 : 0);
        },
        Y: function() { return i.getFullYear(); },
        y: function() { return r.Y().toString().slice(-2); },
        a: function() { return 11 < i.getHours() ? "pm" : "am"; },
        A: function() { return r.a().toUpperCase(); },
        B: function() {
            var A = 3600 * i.getUTCHours(), t = 60 * i.getUTCMinutes(), e = i.getUTCSeconds();
            return n(Math.floor((A + t + e + 3600) / 86.4) % 1e3, 3);
        },
        g: function() { return r.G() % 12 || 12; },
        G: function() { return i.getHours(); },
        h: function() { return n(r.g(), 2); },
        H: function() { return n(r.G(), 2); },
        i: function() { return n(i.getMinutes(), 2); },
        s: function() { return n(i.getSeconds(), 2); },
        u: function() { return n(1e3 * i.getMilliseconds(), 6); },
        e: function() { throw "Not supported (see source code of date() for timezone on how to add support)"; },
        I: function() {
            return new Date(r.Y(), 0) - Date.UTC(r.Y(), 0) != new Date(r.Y(), 6) - Date.UTC(r.Y(), 6) ? 1 : 0;
        },
        O: function() {
            var A = i.getTimezoneOffset(), t = Math.abs(A);
            return (0 < A ? "-" : "+") + n(100 * Math.floor(t / 60) + t % 60, 4);
        },
        P: function() {
            var A = r.O();
            return A.substr(0, 3) + ":" + A.substr(3, 2);
        },
        T: function() { return "UTC"; },
        Z: function() { return 60 * -i.getTimezoneOffset(); },
        c: function() { return "Y-m-d\\TH:i:sP".replace(a, e); },
        r: function() { return "D, d M Y H:i:s O".replace(a, e); },
        U: function() { return i / 1e3 | 0; }
    };
    return this.date = function(A, t) {
        this, i = void 0 === t ? new Date : new Date(t instanceof Date ? t : 1e3 * t);
        return A.replace(a, e);
    }, this.date(A, t);
}

// PHP-like strtotime function
function strtotime(A, t) {
    function e(A) {
        var t = A.split(" "), e = t[0], n = t[1].substring(0, 3), i = /\d+/.test(e),
            r = ("last" === e ? -1 : 1) * ("ago" === t[2] ? -1 : 1);
        if (i && (r *= parseInt(e, 10)), l.hasOwnProperty(n) && !t[1].match(/^mon(day|\.)?$/i)) {
            return a["set" + l[n]](a["get" + l[n]]() + r);
        }
        if ("wee" === n) return a.setDate(a.getDate() + 7 * r);
        if ("next" === e || "last" === e) {
            !function(A, t, e) {
                var n, i = s[t];
                if (void 0 !== i) {
                    n = i - a.getDay();
                    if (n === 0) n = 7 * e;
                    else if (n > 0 && A === "last") n -= 7;
                    else if (n < 0 && A === "next") n += 7;
                    a.setDate(a.getDate() + n);
                }
            }(e, n, r);
        } else if (!i) return !1;
        return !0;
    }
    var n, i, r, o, a, s, l, c, B, u;
    if (!A) return !1;
    A = A.replace(/^\s+|\s+$/g, "").replace(/\s{2,}/g, " ").replace(/[\t\r\n]/g, "").toLowerCase();
    if ((i = A.match(/^(\d{1,4})([\-\.\/\:])(\d{1,2})([\-\.\/\:])(\d{1,4})(?:\s(\d{1,2}):(\d{2})?:?(\d{2})?)?(?:\s([A-Z]+)?)?$/)) && i[2] === i[4]) {
        if (i[1] > 1901) {
            switch (i[2]) {
                case "-": return !(i[3] > 12 || i[5] > 31) && new Date(i[1], parseInt(i[3], 10) - 1, i[5], i[6] || 0, i[7] || 0, i[8] || 0, i[9] || 0) / 1e3;
                case ".": return !1;
                case "/": return !(i[3] > 12 || i[5] > 31) && new Date(i[1], parseInt(i[3], 10) - 1, i[5], i[6] || 0, i[7] || 0, i[8] || 0, i[9] || 0) / 1e3;
            }
        } else if (i[5] > 1901) {
            switch (i[2]) {
                case "-": case ".": return !(i[3] > 12 || i[1] > 31) && new Date(i[5], parseInt(i[3], 10) - 1, i[1], i[6] || 0, i[7] || 0, i[8] || 0, i[9] || 0) / 1e3;
                case "/": return !(i[1] > 12 || i[3] > 31) && new Date(i[5], parseInt(i[1], 10) - 1, i[3], i[6] || 0, i[7] || 0, i[8] || 0, i[9] || 0) / 1e3;
            }
        } else {
            switch (i[2]) {
                case "-":
                    if (!(i[3] > 12 || i[5] > 31 || (i[1] < 70 && i[1] > 38))) {
                        o = i[1] >= 0 && i[1] <= 38 ? +i[1] + 2000 : i[1];
                        return new Date(o, parseInt(i[3], 10) - 1, i[5], i[6] || 0, i[7] || 0, i[8] || 0, i[9] || 0) / 1e3;
                    }
                    break;
                case ".":
                    if (i[5] >= 70) {
                        return !(i[3] > 12 || i[1] > 31) && new Date(i[5], parseInt(i[3], 10) - 1, i[1], i[6] || 0, i[7] || 0, i[8] || 0, i[9] || 0) / 1e3;
                    } else if (i[5] < 60 && !i[6]) {
                        if (!(i[1] > 23 || i[3] > 59)) {
                            r = new Date();
                            return new Date(r.getFullYear(), r.getMonth(), r.getDate(), i[1] || 0, i[3] || 0, i[5] || 0, i[9] || 0) / 1e3;
                        }
                    }
                    break;
                case "/":
                    if (!(i[1] > 12 || i[3] > 31 || (i[5] < 70 && i[5] > 38))) {
                        o = i[5] >= 0 && i[5] <= 38 ? +i[5] + 2000 : i[5];
                        return new Date(o, parseInt(i[1], 10) - 1, i[3], i[6] || 0, i[7] || 0, i[8] || 0, i[9] || 0) / 1e3;
                    }
                    break;
                case ":":
                    if (!(i[1] > 23 || i[3] > 59 || i[5] > 59)) {
                        r = new Date();
                        return new Date(r.getFullYear(), r.getMonth(), r.getDate(), i[1] || 0, i[3] || 0, i[5] || 0) / 1e3;
                    }
                    break;
            }
        }
    }
    if (A === "now") return t === null || isNaN(t) ? (new Date).getTime() / 1e3 | 0 : t | 0;
    if (!isNaN(n = Date.parse(A))) return n / 1e3 | 0;
    a = t ? new Date(t * 1000) : new Date();
    s = { sun: 0, mon: 1, tue: 2, wed: 3, thu: 4, fri: 5, sat: 6 };
    l = { yea: "FullYear", mon: "Month", day: "Date", hou: "Hours", min: "Minutes", sec: "Seconds" };
    B = "(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)";
    i = A.match(new RegExp("([+-]?\\d+\\s" + B + "|(last|next)\\s" + B + ")(\\sago)?", "gi"));
    if (!i) return !1;
    for (u = 0, c = i.length; u < c; u++) if (!e(i[u])) return !1;
    return a.getTime() / 1e3;
}