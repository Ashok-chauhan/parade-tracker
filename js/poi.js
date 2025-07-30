// Restore previous value on load
window.addEventListener("DOMContentLoaded", () => {
	const savedValue = sessionStorage.getItem("selectedOption");
	if (savedValue) {
		document.getElementById("parade_id").value = savedValue;
		displayPoi(savedValue);
	}
});

// Save value on change
document.getElementById("parade_id").addEventListener("change", function () {
	sessionStorage.setItem("selectedOption", this.value);
	//displayPoi(this.value);
});

const poiForm = document.getElementById("poiForm");

poiForm.addEventListener("submit", function (event) {
	// Prevent the default form submission (which would cause a page reload)
	event.preventDefault();

	// Perform form validation here
	if (validateForm()) {
		// If validation passes, you can either:
		// a) Submit the form programmatically (if you don't need the 'submit' event to fire again)
		// myForm.submit();

		// b) Or, handle the submission with AJAX (e.g., using fetch API)
		displayLoading();
		const formData = new FormData(poiForm);
		fetch("/pointofinterest/pointofinterest/", {
			method: "POST",
			body: formData,
		})
			.then((response) => response.json())
			.then((data) => {
				console.log("Success:", data);

				// Clear form fields
				poiForm.reset();
				const savedValue = sessionStorage.getItem("selectedOption");
				if (savedValue) {
					document.getElementById("parade_id").value = savedValue;
					displayPoi(savedValue);
				}
				//displayPoi();
				// Refresh page after 2 seconds (adjust time if needed)
				// setTimeout(() => {
				// 	window.location.reload();
				// }, 2000); // 2000ms = 2 seconds

				// Handle successful submission (e.g., display a success message)
			})
			.catch((error) => {
				console.error("Error:", error);
				// Handle errors
			});
		hideLoading();
	} else {
		// If validation fails, display error messages
		alert("Please correct the form errors.");
	}
});

function validateForm() {
	// Implement your form validation logic here
	// Return true if valid, false otherwise
	const toRoute = document.querySelector("#parade_id").value;
	if (isNaN(toRoute)) {
		alert("Please select parad to add point.");
		return;
	}
	return true; // Placeholder
}

const displayPoi = async (parade_id = "") => {
	let poiContainer = document.querySelector("#poiContainer");
	const form = document.getElementById("poiForm");
	const formData = new FormData(form);
	if (parade_id) {
		formData.append("parade_id", parade_id);
	}
	displayLoading();
	url = "/pointofinterest/displayPoi/";
	const rawResponse = await fetch(url, {
		method: "POST",
		body: formData,
	});
	const content = await rawResponse.json();
	//console.log(content);
	hideLoading();
	sessionStorage.setItem("route_id", formData.get("route_id"));

	poiContainer.innerHTML = "";
	content.forEach((element) => {
		poiContainer.innerHTML += `<tr  class="route-tr"><td class="route-name">  <strong>${element.name} </strong></td>   <td class="route-delete"><button class="btn-delete" onClick="deletePoint(${element.id});">delete</button></td> <td class="route-edit" onClick="editPoi(${element.id});"><button class="btn-edit">Edit</button></td></tr>`;
	});
	//	initializeDragAndDrop();
};

// EDIT POINT OF INTEREST.

const editPoi = async (id) => {
	const formData = new FormData();
	formData.append("id", id);
	url = "/pointofinterest/getPointById/";
	const rawResponse = await fetch(url, {
		method: "POST",
		body: formData,
	});
	const content = await rawResponse.json();

	if (content) {
		console.log(content);
		// populate form data

		document.querySelector("#name").value = content.name;
		document.querySelector("#name").focus();

		document.querySelector("#lat").value = content.lat;
		document.querySelector("#lon").value = content.lon;
		document.querySelector("#category").value = content.category;
		document.querySelector("#image").value = content.image;

		document.querySelector("#pointid").value = content.id;
	}
};

// DELETE POINT

const deletePoint = async (id) => {
	if (confirm("Are you sure you want to delete this point?")) {
		// Save it!
	} else {
		// Do nothing!
		console.log("Thing was not deleted to the database.");
		return;
	}
	const delForm = new FormData();
	delForm.append("id", id);
	url = "/pointofinterest/deletePoint/";
	displayLoading();
	const rawResponse = await fetch(url, {
		method: "POST",
		body: delForm,
	});
	const content = await rawResponse.json();
	if (content.error) {
		alert("Something went wrong, try again!");
	} else {
		const savedValue = sessionStorage.getItem("selectedOption");
		if (savedValue) {
			document.getElementById("parade_id").value = savedValue;
			displayPoi(savedValue);
		}
	}
	hideLoading();
};

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
