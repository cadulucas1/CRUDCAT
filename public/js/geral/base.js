function pag(url = "", params = "") {
    const base = window.location.origin + '/CRUDCAT/';
    window.location.href = base + url + params;
}