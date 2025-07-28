const manageRoute = async () => {
	let toRoute = document.querySelector("#to-routes");
	const form = document.getElementById("toForm");
	const formData = new FormData(form);
	displayLoading();
	url = "/routemanagement/routes/";
	const rawResponse = await fetch(url, {
		method: "POST",
		body: formData,
	});
	const content = await rawResponse.json();

	hideLoading();
	sessionStorage.setItem("route_id", formData.get("route_id"));

	toRoute.innerHTML = "";
	content.forEach((element) => {
		//toRoute.innerHTML += `<li><strong>${element.intersection} </strong> LAT:  ${element.latitude}  LON:  ${element.longitude} <span>Edit</span> <span>delete</span></li>`;
		toRoute.innerHTML += `<tr class="route-tr"><td class="route-name"><strong>${element.intersection} </strong></td>   <td class="route-delete"><button class="btn-delete" onClick="deleteRoute(${element.id});">delete</button></td> <td class="route-edit" onClick="editRoute(${element.id});"><button class="btn-edit">Edit</button></td></tr>`;
	});
};

const toParadeRoute = async () => {
	let toRoute = document.querySelector("#to-routes");
	const form = document.getElementById("toForm");
	const formData = new FormData(form);
	displayLoading();
	url = "/routemanagement/routes/";
	const rawResponse = await fetch(url, {
		method: "POST",
		body: formData,
	});
	const content = await rawResponse.json();

	hideLoading();
	toRoute.innerHTML = `<ul>`;
	content.forEach((element) => {
		toRoute.innerHTML += `<li><strong>${element.intersection} </strong> LAT:  ${element.latitude}  LON:  ${element.longitude} </li>`;
	});
	toRoute.innerHTML += `</ul>`;
	//console.log(content);
};

const fromParadeRoute = async () => {
	let fromRoute = document.querySelector("#from-routes");
	const form = document.getElementById("fromForm");
	const formData = new FormData(form);
	displayLoading();
	url = "/routemanagement/routes/";
	const rawResponse = await fetch(url, {
		method: "POST",
		body: formData,
	});
	const content = await rawResponse.json();
	hideLoading();
	fromRoute.innerHTML = "<ul>";
	content.forEach((element) => {
		fromRoute.innerHTML += `<li><strong>${element.intersection} </strong> LAT:  ${element.latitude}  LON:  ${element.longitude} </li>`;
	});
	fromRoute.innerHTML += "</ul>";
	//generateForm();
};

const btn = document.querySelector("#btn");
if (btn) {
	btn.addEventListener("click", async (e) => {
		e.preventDefault();
		const toRoute = document.querySelector("#to_route_id").value;
		const fromRoute = document.querySelector("#from_route_id").value;
		if (isNaN(toRoute) || isNaN(fromRoute)) {
			alert("Please select To and From route to update routes");
			return;
		}

		const form = document.getElementById("generateRouteForm");
		const formData = new FormData(form);
		formData.append("toRoute", toRoute);
		formData.append("fromRoute", fromRoute);
		displayLoading();
		url = "/routemanagement/copyRoute/";
		const rawResponse = await fetch(url, {
			method: "POST",
			body: formData,
		});
		const content = await rawResponse.json();
		if (content.error) {
			const btn = document.querySelector("#done");
			document.querySelector("#result").textContent = content.result;
			btn.style.background = "red";
			btn.textContent = "Error!";
		} else {
			document.querySelector("#result").textContent = content.result;
		}

		hideLoading();
		if (content) {
			dialog.showModal();
			openCheck(dialog);
		}
		//console.log(content);
	});
}
// dialog / modal bof
//const updateButton = document.getElementById("updateDetails");
const cancelButton = document.getElementById("done");
const dialog = document.getElementById("favDialog");

function openCheck(dialog) {
	if (dialog.open) {
		console.log("Dialog open");
	} else {
		console.log("Dialog closed");

		const routeid = sessionStorage.getItem("route_id");
		reloadPage(routeid);
	}
}

// Form cancel button closes the dialog box
if (cancelButton) {
	cancelButton.addEventListener("click", () => {
		// dialog.close("animalNotChosen");
		dialog.close();
		openCheck(dialog);
	});
}

// dialog / modal eof
// bof loader
const loader = document.querySelector("#loading");
const displayLoading = () => {
	loader.classList.add("display");

	setTimeout(() => {
		loader.classList.remove("display");
	}, 5000);
};
const hideLoading = () => {
	loader.classList.remove("display");
};
// eof loader

const editRoute = async (id) => {
	const formData = new FormData();
	formData.append("id", id);
	url = "/routemanagement/getRoutbyId/";
	const rawResponse = await fetch(url, {
		method: "POST",
		body: formData,
	});
	const content = await rawResponse.json();

	if (content) {
		// populate form data
		document.querySelector("#result").textContent = "";
		document.querySelector("#intersection").value = content.intersection;
		document.querySelector("#latitude").value = content.latitude;
		document.querySelector("#longitude").value = content.longitude;
		document.querySelector("#id").value = content.id;

		routeedit.showModal();
		openCheckRoute(routeedit);
	}
};
const deleteRoute = async (id) => {
	if (confirm("Are you sure you want to delete this route?")) {
		// Save it!
	} else {
		// Do nothing!
		console.log("Thing was not deleted to the database.");
		return;
	}
	const delForm = new FormData();
	delForm.append("id", id);
	url = "/routemanagement/deleteRoute/";
	displayLoading();
	const rawResponse = await fetch(url, {
		method: "POST",
		body: delForm,
	});
	const content = await rawResponse.json();
	if (content.error) {
		const btn = document.querySelector("#done");
		document.querySelector("#result").textContent = content.result;
		btn.style.background = "red";
		btn.textContent = "Error!";
	} else {
		document.querySelector("#result").textContent = content.result;
	}

	hideLoading();
	if (content) {
		dialog.showModal();
		openCheck(dialog);
	}
};

// bof route edit dialog

const cancelEdit = document.getElementById("doneRoute");

const btnUpdateSubmit = document.getElementById("updateRoute");
const routeedit = document.getElementById("route-edit");

function openCheckRoute(routeedit) {
	if (routeedit.open) {
		console.log("Dialog open");
	} else {
		console.log("Dialog closed+");
	}
}

// Form cancel button closes the dialog box
cancelEdit.addEventListener("click", () => {
	// dialog.close("animalNotChosen");
	routeedit.close();
	openCheckRoute(routeedit);
});
btnUpdateSubmit.addEventListener("click", () => {
	routeedit.close();
	openCheckRoute(routeedit);
});

const frfUpdate = document.querySelector("#frmUpdate");

frfUpdate.addEventListener("submit", async (e) => {
	e.preventDefault();
	const formData = new FormData(frfUpdate);
	formData.append("id", document.querySelector("#id").value);
	formData.append(
		"intersection",
		document.querySelector("#intersection").value
	);
	formData.append("latitude", document.querySelector("#latitude").value);
	formData.append("longitude", document.querySelector("#longitude").value);
	url = "/routemanagement/updateRoutebyId/";
	try {
		displayLoading();
		const rawResponse = await fetch(url, {
			method: "POST",
			body: formData,
		});
		const content = await rawResponse.json();

		if (content.error) {
			const btn = document.querySelector("#done");
			document.querySelector("#result").textContent = content.result;
			btn.style.background = "red";
			btn.textContent = "Error!";
		} else {
			document.querySelector("#result").textContent = content.result;
		}

		hideLoading();
		if (content) {
			dialog.showModal();
			openCheck(dialog);
		}
		hideLoading();
	} catch (error) {
		console.log("Error during route update/edit :", error);
	}
});

// eof route edit dialog

// page reload bof

const reloadPage = async (id) => {
	let toRoute = document.querySelector("#to-routes");
	const formData = new FormData();
	formData.append("route_id", id);
	displayLoading();
	url = "/routemanagement/routes/";
	const rawResponse = await fetch(url, {
		method: "POST",
		body: formData,
	});
	const content = await rawResponse.json();

	hideLoading();
	toRoute.innerHTML = "";
	content.forEach((element) => {
		//toRoute.innerHTML += `<li><strong>${element.intersection} </strong> LAT:  ${element.latitude}  LON:  ${element.longitude} <span>Edit</span> <span>delete</span></li>`;
		toRoute.innerHTML += `<tr class="route-tr"><td class="route-name"><strong>${element.intersection} </strong></td>   <td class="route-delete"><button class="btn-delete" onClick="deleteRoute(${element.id});">delete</button></td> <td class="route-edit" onClick="editRoute(${element.id});"><button class="btn-edit">Edit</button></td></tr>`;
	});
};

// page reload eof
