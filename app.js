document.addEventListener("DOMContentLoaded", () => {
    const getBtn = document.getElementById("getBtn");
    const apiData = document.getElementById("apiData");
    const apiform = document.getElementById("apiForm");
    const url = "https://randomuser.me/api/";

    getBtn.addEventListener("click", getUser);

    function getUser(){
        fetch(url)
        .then(decodeData)
        .then(success, fail);
    }

    function decodeData(response){
        if(response.ok){
            apiData.innerHTML = "Response is " + response.status + " (OK)";
            return response.json();
        } else {
            throw response.status;
        }
    }

    function success(userData){
        const user = userData.results[0];

        apiData.innerHTML = `
        <img class="user" src="${user.picture.large}" alt="random user"/>
        <h2 class="user"> Meet ${user.name.first} ${user.name.last}</h2>
        <p>Country: ${user.location.country}</p>
        `;

        document.getElementById("first-input").value = user.name.first;
        document.getElementById("last-input").value = user.name.last;
        document.getElementById("country-input").value = user.location.country;

    }

    function fail(error){
        apiData.innerHTML = `
        <p>Something went wrong while fetching or parsing JSON.</p>
        <p>Error code: ${error}</p>
        <p><a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Status" target="_blank">View HTTP Status Codes</a></p>
        `;
    }
});