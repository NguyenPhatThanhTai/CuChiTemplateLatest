/* resources/scripts/admin-app.js */
(function ($) {
  // ---------- helpers ----------
  const ajax = (action, data = {}) =>
    $.ajax({
      url: ADMIN_TOOL.ajaxurl,
      type: "POST",
      data: { action, _ajax_nonce: ADMIN_TOOL.nonce, ...data },
    });

  const $root = () => document.getElementById("view-root");
  const html = (el, h) => (el.innerHTML = h);
  const fmt = (n) => (n === null || n === undefined ? "" : Number(n).toLocaleString());

  // ---------- router views ----------
  const Views = {
    dashboard() {
      detachRootHandler();
      html($root(), `<div class="card"><h2>Dashboard</h2><p>Welcome back.</p></div>`);
    },

    async rooms() {
      try {
        const res = await ajax("admin_tool_rooms_list");
        if (!res.success) throw new Error(res.data?.message || "Load failed");

        const rows = res.data;
        html(
          $root(),
          `
          <div class="card">
            <div class="card-head">
              <h2>Rooms</h2>
              <div class="button-add">
                  <button class="btn btn-primary" id="btnAddRoom">+ Add Room</button>
              </div>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th><th>Name</th><th>Type</th><th>Slot</th>
                  <th>Price</th><th>Total</th><th>Images</th>
                </tr>
              </thead>
              <tbody>
                ${rows
                  .map(
                    (r) => `
                  <tr data-id="${r.id}" data-ids="${(r.image_ids || []).join(",")}">
                    <td>${r.id}</td>
                    <td>${r.room_name}</td>
                    <td>${r.room_type || "-"}</td>
                    <td>${r.slot}</td>
                    <td>${fmt(r.price)}</td>
                    <td>${r.total_rooms}</td>
                    <td>
                      <button class="btn btn-link btn-images btn-view-image">View / Change (${(r.image_ids || []).length})</button>
                    </td>
                  </tr>`
                  )
                  .join("")}
              </tbody>
            </table>
          </div>
        `
        );

        // Single delegated click handler for this view (replaces any previous handler)
        attachRootHandler(async (ev) => {
          // images button
          const btnImages = ev.target.closest(".btn-images");
          if (btnImages) {
            const tr = btnImages.closest("tr");
            if (!tr) return;
            openImagesModal({
              mode: "edit",
              roomId: Number(tr.dataset.id),
              currentIds: (tr.dataset.ids || "")
                .split(",")
                .map((x) => (x ? Number(x) : null))
                .filter(Boolean),
              onSaved: () => Views.rooms(),
            });
            return;
          }

          // add room
          if (ev.target.id === "btnAddRoom") {
            openCreateRoomModal({ onSaved: () => Views.rooms() });
            return;
          }
        });
      } catch (err) {
        renderError(err.message);
      }
    },

    async bookings() {
      detachRootHandler();
      const res = await ajax("admin_tool_bookings_list");
      if (!res.success) return renderError(res.data?.message);
      const rows = res.data;
      html(
        $root(),
        `
      <div class="card">
        <h2>Bookings</h2>
        <table class="table">
          <thead><tr>
            <th>ID</th><th>Room</th><th>Email</th><th>Check-in</th>
            <th>Check-out</th><th>Checked in</th><th>Action</th>
          </tr></thead>
          <tbody>
            ${rows
              .map(
                (b) => `
              <tr>
                <td>${b.id}</td>
                <td>${b.room_name}</td>
                <td>${b.email}</td>
                <td>${b.check_in}</td>
                <td>${b.check_out}</td>
                <td>${b.checked_in ? '<span class="badge ok">YES</span>' : '<span class="badge fail">NO</span>'}</td>
                <td>${b.checked_in ? "" : `<button class="btn btn-sm btn-primary" data-id="${b.id}" data-act="checkin">Mark check-in</button>`}</td>
              </tr>`
              )
              .join("")}
          </tbody>
        </table>
      </div>`
      );

      $root()
        .querySelectorAll('[data-act="checkin"]')
        .forEach((btn) =>
          btn.addEventListener("click", async () => {
            const r = await ajax("admin_tool_booking_checkin", { id: btn.dataset.id });
            if (!r.success) return alert(r.data?.message || "Error");
            Views.bookings();
          })
        );
    },

    async transactions() {
      detachRootHandler();
      const res = await ajax("admin_tool_transactions_list");
      if (!res.success) return renderError(res.data?.message);
      const rows = res.data;
      html(
        $root(),
        `
      <div class="card">
        <h2>Transactions</h2>
        <table class="table">
          <thead>
            <tr><th>ID</th><th>Room</th><th>Type</th><th>Email</th>
            <th>Check-in</th><th>Check-out</th><th>Status</th><th>Action</th></tr>
          </thead>
          <tbody>
            ${rows
              .map(
                (t) => `
              <tr>
                <td>${t.id}</td>
                <td>${t.room_name}</td>
                <td>${t.room_type || "-"}</td>
                <td>${t.email}</td>
                <td>${t.check_in}</td>
                <td>${t.check_out}</td>
                <td>${t.is_success ? '<span class="badge ok">SUCCESS</span>' : '<span class="badge fail">PENDING</span>'}</td>
                <td>
                  <select class="tx" data-id="${t.id}">
                    <option value="1" ${t.is_success ? "selected" : ""}>Success</option>
                    <option value="0" ${!t.is_success ? "selected" : ""}>Pending</option>
                  </select>
                </td>
              </tr>`
              )
              .join("")}
          </tbody>
        </table>
      </div>`
      );

      $root()
        .querySelectorAll("select.tx")
        .forEach((s) =>
          s.addEventListener("change", async () => {
            const r = await ajax("admin_tool_transaction_update", { id: s.dataset.id, is_success: s.value });
            if (!r.success) alert(r.data?.message || "Update failed");
          })
        );
    },
  };

  const renderError = (msg) =>
    html($root(), `<div class="card"><h2>Error</h2><p>${msg || "Unknown error"}</p></div>`);

  const routes = {
    "#/dashboard": Views.dashboard,
    "#/rooms": Views.rooms,
    "#/bookings": Views.bookings,
    "#/transactions": Views.transactions,
  };
  const go = () => (routes[location.hash] || Views.dashboard)();
  window.addEventListener("hashchange", go);

  // ---------- modal UI (images) ----------
  const MODAL_SHELL = `
  <div id="at-modal" class="at-modal" aria-hidden="true" style="display:none">
  <div class="at-backdrop"></div>
  <div class="at-dialog" role="dialog" aria-modal="true" aria-labelledby="at-title">
      <div class="at-head">
      <h3 id="at-title">Edit images</h3>
      <button type="button" class="at-x" id="at_btn_close" aria-label="Close">×</button>
      </div>
      <div class="at-body">
      <div class="grid4">
          ${[0,1,2,3].map(i => `
          <div class="slot" data-slot="${i}">
              <div class="thumb"><span>No image</span></div>
              <div class="row">
              <button type="button" class="at-btn" data-choose="${i}">Choose</button>
              <button type="button" class="at-btn at-btn-danger" data-remove="${i}">Remove</button>
              </div>
          </div>
          `).join('')}
      </div>
      </div>
      <div class="at-foot">
      <button type="button" class="at-btn" id="at_btn_cancel">Cancel</button>
      <button type="button" class="at-btn at-btn-primary" id="at_btn_save">Save</button>
      </div>
  </div>
  </div>`;


  // open modal for existing room
  async function openImagesModal({ roomId, currentIds = [], onSaved }) {
    const modal = document.getElementById("at-modal");
    const title = modal.querySelector("#at-title");
    title.textContent = `Edit Room #${roomId} images`;
    await hydrateSlots(modal, currentIds);

    showModal(modal);

    // Choose image via WP Media Library
    modal.querySelectorAll("[data-choose]").forEach((btn) => {
      btn.onclick = async () => {
        const slot = Number(btn.dataset.choose);
        const id = await pickOneFromMedia();
        console.log("Picked media ID:", id);
        if (id) await putIdIntoSlot(modal, slot, id);
      };
    });

    // Remove
    modal.querySelectorAll("[data-remove]").forEach((btn) => {
      btn.onclick = () => clearSlot(modal, Number(btn.dataset.remove));
    });

    modal.querySelector("#at_btn_cancel").onclick = () => hideModal(modal);
    modal.querySelector("#at_btn_close").onclick = () => hideModal(modal);

    modal.querySelector("#at_btn_save").onclick = async () => {
      const ids = collectIds(modal);
      const r = await ajax("admin_tool_room_update_images", {
        id: roomId,
        image_ids: ids.join(","),
      });
      if (!r.success) return alert(r.data?.message || "Update failed");
      hideModal(modal);
      onSaved && onSaved();
    };
  }

  // create new room (with images)
  async function openCreateRoomModal({ onSaved }) {
    const modal = document.getElementById("at-modal");
    const title = modal.querySelector("#at-title");
    title.textContent = "Create room";

    // replace body with a small form + images grid
    const body = modal.querySelector(".at-body");
    body.innerHTML = `
      <div class="form two-col">
        <div class="label-input"><label>Name<input id="cr_name" type="text" required value="New room"></label></div>
        <div class="label-input"><label>Type<input id="cr_type" type="text"></label></div>
        <div class="label-input"><label>Slot<input id="cr_slot" type="number" min="1" value="1"></label></div>
        <div class="label-input"><label>Total rooms<input id="cr_total" type="number" min="1" value="1"></label></div>
        <div class="label-input"><label>Price<input id="cr_price" type="number" step="0.01" min="0" value="0"></label></div>
      </div>
      <div class="mt8"><b>Images (up to 4)</b></div>
      <div class="grid4">
        ${[0, 1, 2, 3]
          .map(
            (i) => `
          <div class="slot" data-slot="${i}">
            <div class="thumb"><span>No image</span></div>
            <div class="row">
              <button class="btn btn-sm" data-choose="${i}">Choose</button>
              <button class="btn btn-sm btn-danger" data-remove="${i}">Remove</button>
            </div>
          </div>`
          )
          .join("")}
      </div>
    `;

    showModal(modal);

    // choose/remove logic
    body.querySelectorAll("[data-choose]").forEach((btn) => {
      btn.onclick = async () => {
        const slot = Number(btn.dataset.choose);
        const id = await pickOneFromMedia();
        if (id) await putIdIntoSlot(modal, slot, id);
      };
    });
    body.querySelectorAll("[data-remove]").forEach((btn) => {
      btn.onclick = () => clearSlot(modal, Number(btn.dataset.remove));
    });

    modal.querySelector("#at_btn_cancel").onclick = () => hideModal(modal);
    modal.querySelector("#at_btn_close").onclick = () => hideModal(modal);

    modal.querySelector("#at_btn_save").onclick = async () => {
      const payload = {
        room_name: body.querySelector("#cr_name").value.trim(),
        room_type: body.querySelector("#cr_type").value.trim(),
        slot: body.querySelector("#cr_slot").value,
        total_rooms: body.querySelector("#cr_total").value,
        price: body.querySelector("#cr_price").value,
        image_ids: collectIds(modal).join(","),
      };
      const r = await ajax("admin_tool_room_create", payload);
      if (!r.success) return alert(r.data?.message || "Create failed");
      hideModal(modal);
      onSaved && onSaved();
    };
  }

  // ---------- slot helpers ----------
  async function hydrateSlots(modal, ids) {
    // clear all
    modal.querySelectorAll(".slot").forEach((slot) => clearSlot(modal, Number(slot.dataset.slot)));
    if (!ids || !ids.length) return;

    // resolve IDs → URLs (support two possible payload shapes)
    const r = await ajax("admin_tool_media_urls", { ids: ids.join(",") });
    if (!r.success) return;

    const items =
      r.data?.items ??
      (r.data?.urls
        ? ids.map((id, i) => ({ id, url: r.data.urls[i] || "", ok: !!r.data.urls[i] }))
        : []);

    // place into slots in order
    items.forEach((it, idx) => {
      if (!it || !it.id) return;
      setSlot(modal, idx, it.id, it.url, it.ok !== false);
    });
  }

  function collectIds(modal) {
    const out = [];
    modal.querySelectorAll(".slot").forEach((slot) => {
      const id = Number(slot.getAttribute("data-id") || 0);
      if (id) out.push(id);
    });
    return out;
  }

  function setSlot(modal, slotIndex, id, url, ok = true) {
    const slot = modal.querySelector(`.slot[data-slot="${slotIndex}"]`);
    if (!slot) return;
    slot.setAttribute("data-id", id);
    const box = slot.querySelector(".thumb");
    box.innerHTML = `<img src="${url}" alt=""><div class="chip ${ok ? "ok" : "bad"}">${ok ? "OK" : "Missing"}</div>`;
  }

  function clearSlot(modal, slotIndex) {
    const slot = modal.querySelector(`.slot[data-slot="${slotIndex}"]`);
    if (!slot) return;
    slot.removeAttribute("data-id");
    const box = slot.querySelector(".thumb");
    box.innerHTML = `<span>No image</span>`;
  }

  async function putIdIntoSlot(modal, slot, id) {
    const r = await ajax("admin_tool_media_urls", { ids: String(id) });
    if (!r.success) return;
    const items =
      r.data?.items ??
      (r.data?.urls ? [{ id, url: r.data.urls[0] || "", ok: !!r.data.urls[0] }] : []);
    if (!items || !items[0]) return;
    const it = items[0];
    setSlot(modal, slot, it.id, it.url, it.ok !== false);
  }

  // ---------- wp.media picker ----------
  // Open WP media library and get the selected attachment ID
  async function pickOneFromMedia() {
    return new Promise((resolve) => {
      if (!window.wp || !wp.media) {
        alert("WordPress media library is not available.");
        return resolve(null);
      }
  
      const frame = wp.media({
        title: "Select image",
        button: { text: "Use this image" },
        library: { type: "image" },
        multiple: false,
      });
  
      let done = false;
      const finish = (val) => {
        if (done) return;
        done = true;
        // make sure we don't fire close afterwards
        frame.off("close");
        resolve(val);
      };
  
      // Modern event
      frame.once("select", () => {
        const sel = frame.state().get("selection");
        const first = sel && sel.first && sel.first();
        const data = first ? first.toJSON() : null;
        const id = data ? data.id : null;
        console.log("Selected media (select):", data);
        finish(id ?? null);
      });
  
      // Some WP setups trigger 'insert' instead of 'select'
      frame.once("insert", () => {
        const sel = frame.state().get("selection");
        const first = sel && sel.first && sel.first();
        const data = first ? first.toJSON() : null;
        const id = data ? data.id : null;
        console.log("Selected media (insert):", data);
        finish(id ?? null);
      });
  
      frame.open();
    });
  }    

  // ---------- modal show/hide ----------
  function showModal(m) {
    m.classList.remove("hidden");
    m.setAttribute("aria-hidden", "false");
  }
  function hideModal(m) {
    m.classList.add("hidden");
    m.setAttribute("aria-hidden", "true");
  }

  // ---------- root click handler attach/detach ----------
  function attachRootHandler(fn) {
    detachRootHandler();
    $root().onclick = fn;
  }
  function detachRootHandler() {
    const r = $root();
    if (r) r.onclick = null;
  }

  function showModal(m) {
      m.style.display = 'block';        // <-- ensure it’s clickable
      m.classList.remove('hidden');
      m.setAttribute('aria-hidden', 'false');
    }
    
    function hideModal(m) {
      m.style.display = 'none';         // <-- ensure it can’t block clicks
      m.classList.add('hidden');
      m.setAttribute('aria-hidden', 'true');
    }
    

  // ---------- boot ----------
  (function init() {
    // Put the modal at the end of <body> ONCE so it never overlays the table when "hidden"
    if (!document.getElementById("at-modal")) {
      document.body.insertAdjacentHTML("beforeend", MODAL_SHELL);
    }

    if (!location.hash) location.hash = "#/rooms";
    go();
  })();
})(jQuery);
