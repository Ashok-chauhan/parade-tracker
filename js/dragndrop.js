const list = document.getElementById("to-routes");
// let draggedItem = null;
const dismisDialog = document.getElementById("drag");
const dragDialog = document.getElementById("dragDialog");

function initializeDragAndDrop() {
	let draggedItem = null;
	list.querySelectorAll("tbody").forEach((item) => {
		item.addEventListener("dragstart", () => {
			draggedItem = item;

			//item.classList.add("dragging");
		});

		item.addEventListener("dragend", () => {
			item.classList.remove("dragging");
			draggedItem = null;

			const order = Array.from(list.children).map((li) => li.dataset.id);
			displayLoading();
			fetch("/routemanagement/updateRouteOrder", {
				method: "POST",
				headers: { "Content-Type": "application/json" },
				body: JSON.stringify({ order }),
			})
				.then((res) => res.json())
				.then((data) => {
					dragDialog.showModal();
					dragCheck(dragDialog, data);
				}) //dragCheck(dragDialog, data)) //console.log(data))
				.catch((err) => console.error(err));
			hideLoading();
		});

		item.addEventListener("dragover", (e) => e.preventDefault());
		item.addEventListener("drop", (e) => {
			e.preventDefault();
			if (draggedItem && draggedItem !== item) {
				const items = Array.from(list.children);
				const draggedIndex = items.indexOf(draggedItem);
				const targetIndex = items.indexOf(item);

				if (draggedIndex < targetIndex) {
					list.insertBefore(draggedItem, item.nextSibling);
				} else {
					list.insertBefore(draggedItem, item);
				}
			}
		});
	});
}

function dragCheck(dragDialog, data = {}) {
	if (dragDialog.open) {
		console.log("Drag Dialog open");
		if (data.error) {
			document.getElementById(
				"drag"
			).innerHTML = `<span style="color:yellow;">${data.result}</span>`;
		} else {
			document.getElementById("drag").textContent = data.result;
		}
	} else {
		console.log("Drag Dialog closed");
	}
}

if (dismisDialog) {
	dismisDialog.addEventListener("click", () => {
		dragDialog.close();
		dragCheck(dragDialog);
	});
}
