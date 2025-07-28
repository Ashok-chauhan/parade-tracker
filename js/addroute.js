const addRoute = async (id) => {
	const toRoute = document.querySelector("#to_route_id").value;
	if (isNaN(toRoute)) {
		alert("Please select parad to add route.");
		return;
	}

	document.querySelector("#addresult").textContent = "";
	document.getElementById("frmAdd").reset();

	routeAdd.showModal();
	openCheckRoute(routeAdd);
};
// bof route edit dialog

const doneRouteAdd = document.getElementById("doneRouteAdd");
const btnAddSubmit = document.getElementById("addRouteSubmit");
const routeAdd = document.getElementById("route-add");

function openCheckRoute(routeAdd) {
	if (routeAdd.open) {
		console.log("Dialog open");
	} else {
		console.log("Dialog closed");
	}
}

// Form cancel button closes the dialog box
doneRouteAdd.addEventListener("click", () => {
	// dialog.close("animalNotChosen");
	routeAdd.close();
	openCheckRoute(routeAdd);
});
btnAddSubmit.addEventListener("click", () => {
	routeAdd.close();
	openCheckRoute(routeAdd);
});

const frmAdd = document.querySelector("#frmAdd");
async function sendData() {
	// Associate the FormData object with the form element
	const formData = new FormData(frmAdd);
	const toRoute = document.querySelector("#to_route_id").value;
	formData.append("route_id", toRoute);

	try {
		const url = "/routemanagement/addRoutebyId/";
		displayLoading();

		const response = await fetch(url, {
			method: "POST",
			// Set the FormData instance as the request body
			body: formData,
		});
		// console.log(await response.json());
		const content = await response.json();
		console.log(content);
		if (content.error) {
			const btn = document.querySelector("#done");
			document.querySelector("#addresult").textContent = content.result;
			btn.style.background = "red";
			btn.textContent = "Error!";
		} else {
			document.querySelector("#addresult").textContent = content.result;
		}

		hideLoading();
		if (content) {
			dialog.showModal();
			openCheck(dialog);
		}
		hideLoading();
	} catch (e) {
		console.error(e);
	}
}

// Take over form submission
frmAdd.addEventListener("submit", (event) => {
	event.preventDefault();
	sendData();
});

// eof route edit dialog
