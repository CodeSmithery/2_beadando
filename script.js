const api = "api.php";
document.getElementById("userForm").addEventListener("submit", saveUser);
window.onload = function() {
    fetchUsers();
};
function fetchUsers() {
    document.getElementById("addedit").innerHTML = "Add new user";
    fetch(api,{
            method: 'post',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: "action=read"
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById("message").innerText += " "+data.status;
            let rows = "";
            data.readData.forEach(user => {
                rows += `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>
                        <button onclick='editUser(${JSON.stringify(user)})'>Edit</button>
                        <button onclick='deleteUser(${user.id})'>Delete</button>
                    </td>
                </tr>`;
            });
            document.getElementById("userTable").innerHTML = rows;
        });
}
function saveUser(e) {
    e.preventDefault();
    const id = document.getElementById("id").value;
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const action = id ? "update" : "create";
        //var action = "update"; if(id=="") action = "create";
    fetch(api, {
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: "action="+action+"&id="+id+"&name="+name+"&email="+email
    })
    .then(res => res.json())
    .then(data => {
        e.target.reset();
        document.getElementById("message").innerText = data.status;
        document.getElementById("id").value = "";
        fetchUsers();
    });
}

function editUser(user) {
    document.getElementById("message").innerText = "";
    document.getElementById("addedit").innerHTML = "Edit user";
    document.getElementById("id").value = user.id;
    document.getElementById("name").value = user.name;
    document.getElementById("email").value = user.email;
}

function deleteUser(id) {
    if (!confirm("Delete this user?")) return;
    fetch(api, {
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body:"action=delete&id="+id
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById("message").innerText = data.status;
        fetchUsers();
    });
}

