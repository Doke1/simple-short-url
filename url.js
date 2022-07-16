document.addEventListener("DOMContentLoaded", () => {
    const url = document.getElementById("url");
    const btn = document.getElementById("btn");
    const uri = document.getElementById("short-url");

    let fetchUrl = `${window.location.href}random/`;
    btn.addEventListener("click", () => {
        fetch(fetchUrl, {
            method: "POST",
            body: JSON.stringify({location: url.value}),
            header: {
                "Content-Type": "application/json"
            }
        }).then((res) => {
            res.text().then((data) => {
                uri.innerHTML = data;
            })
        }).catch((err) => {console.log(err)})
    })
});