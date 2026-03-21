/**
 * ajax-handlers.js
 * Centralized AJAX handlers for the dashboard project.
 * Covers: Categories (CRUD), Items/Forms (CRUD), flash alerts.
 */

$(function () {

    /* ──────────────────────────────────────────────────────────
     * HELPER: Read the CSRF token from the meta tag once.
     * Make sure your layout has:
     *   <meta name="csrf-token" content="{{ csrf_token() }}">
     * ────────────────────────────────────────────────────────── */
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });


    /* ══════════════════════════════════════════════════════════
     *  SECTION 1 – CATEGORY CRUD (page: /category)
     * ══════════════════════════════════════════════════════════ */

    // ── 1a. DELETE category without page reload ──────────────
    $(document).on('submit', '.ajax-delete-category', function (e) {
        e.preventDefault();

        const form    = $(this);
        const row     = form.closest('tr');
        const url     = form.attr('action');

        if (!confirm('Are you sure you want to delete this category?')) return;

        $.ajax({
            url:    url,
            method: 'POST',            // Laravel DELETE tunneled via _method
            data:   form.serialize(),  // includes _token + _method=DELETE
            success: function () {
                row.fadeOut(400, function () { $(this).remove(); });
                showAlert('success', 'Category deleted successfully.');
            },
            error: function (xhr) {
                showAlert('danger', 'Error deleting category: ' + getErrorMsg(xhr));
            }
        });
    });


    /* ══════════════════════════════════════════════════════════
     *  SECTION 2 – ITEM (Lost & Found) CRUD (page: /forms)
     * ══════════════════════════════════════════════════════════ */

    // ── 2a. CREATE item via AJAX (inline form submit) ─────────
    $(document).on('submit', '#ajax-create-item-form', function (e) {
        e.preventDefault();

        const form    = $(this);
        const btn     = form.find('[type="submit"]');
        const origTxt = btn.text();

        btn.prop('disabled', true).text('Saving…');
        clearFormErrors(form);

        $.ajax({
            url:    form.attr('action'),
            method: 'POST',
            data:   form.serialize(),
            success: function (res) {
                form[0].reset();
                btn.prop('disabled', false).text(origTxt);
                showAlert('success', res.message || 'Item reported successfully.');
                appendItemRow(res.item);   // inject row into table without reload
            },
            error: function (xhr) {
                btn.prop('disabled', false).text(origTxt);
                if (xhr.status === 422) {
                    renderFormErrors(form, xhr.responseJSON.errors);
                } else {
                    showAlert('danger', 'Error: ' + getErrorMsg(xhr));
                }
            }
        });
    });


    // ── 2b. DELETE item without page reload ───────────────────
    $(document).on('submit', '.ajax-delete-item', function (e) {
        e.preventDefault();

        const form = $(this);
        const row  = form.closest('tr');
        const url  = form.attr('action');

        if (!confirm('Delete this item?')) return;

        $.ajax({
            url:    url,
            method: 'POST',
            data:   form.serialize(),
            success: function (res) {
                row.fadeOut(400, function () { $(this).remove(); });
                showAlert('success', res.message || 'Item deleted successfully.');
            },
            error: function (xhr) {
                showAlert('danger', 'Error deleting item: ' + getErrorMsg(xhr));
            }
        });
    });


    // ── 2c. STATUS UPDATE (inline dropdown/select in the table) ─
    $(document).on('change', '.ajax-status-select', function () {
        const select = $(this);
        const itemId = select.data('id');
        const status = select.val();

        $.ajax({
            url:    '/forms/' + itemId,      // PUT /forms/{item}
            method: 'POST',
            data: {
                _method:         'PUT',
                _token:          $('meta[name="csrf-token"]').attr('content'),
                status:          status,
                // Send remaining required fields with their current values
                // stored as data attributes on the <select>
                name:            select.data('name'),
                description:     select.data('description'),
                date:            select.data('date'),
                type:            select.data('type'),
                reporter_name:   select.data('reporter_name'),
                contact_no:      select.data('contact_no'),
            },
            success: function (res) {
                showAlert('success', res.message || 'Status updated.');
                // Optionally update the badge next to the select
                const badge = select.closest('tr').find('.status-badge');
                badge.text(status)
                     .removeClass('badge-success badge-warning badge-secondary badge-danger')
                     .addClass(statusBadgeClass(status));
            },
            error: function (xhr) {
                showAlert('danger', 'Could not update status: ' + getErrorMsg(xhr));
                // Revert the select to the previous value
                select.val(select.data('original-status'));
            }
        });
    });

    // Store the original status before change so we can revert on error
    $(document).on('focus', '.ajax-status-select', function () {
        $(this).data('original-status', $(this).val());
    });


    /* ══════════════════════════════════════════════════════════
     *  PRIVATE UTILITY FUNCTIONS
     * ══════════════════════════════════════════════════════════ */

    /**
     * Show a Bootstrap dismissible alert at the top of #ajax-alert-container.
     * @param {'success'|'danger'|'warning'|'info'} type
     * @param {string} message
     */
    function showAlert(type, message) {
        const alert = $(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        $('#ajax-alert-container').html(alert);
        // Auto-dismiss after 4 seconds
        setTimeout(() => alert.alert('close'), 4000);
    }

    /**
     * Render Laravel validation errors under each field.
     * Expects fields to have id="fieldName" and a sibling .invalid-feedback.
     */
    function renderFormErrors(form, errors) {
        $.each(errors, function (field, messages) {
            const input = form.find('[name="' + field + '"]');
            input.addClass('is-invalid');
            let fb = input.siblings('.invalid-feedback');
            if (!fb.length) {
                fb = $('<div class="invalid-feedback"></div>').insertAfter(input);
            }
            fb.text(messages[0]);
        });
    }

    /** Remove previous validation states from a form */
    function clearFormErrors(form) {
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').text('');
    }

    /** Extract a human-readable error from an XHR response */
    function getErrorMsg(xhr) {
        if (xhr.responseJSON && xhr.responseJSON.message) return xhr.responseJSON.message;
        return xhr.statusText || 'Unknown error';
    }

    /** Map status string to Bootstrap badge class */
    function statusBadgeClass(status) {
        const map = {
            'Pending':  'badge-warning',
            'Resolved': 'badge-success',
            'Closed':   'badge-secondary',
            'Rejected': 'badge-danger',
        };
        return map[status] || 'badge-warning';
    }

    /**
     * Append a newly created item as a <tr> into #items-table-body.
     * Called after a successful AJAX create.
     */
    function appendItemRow(item) {
        const tbody = $('#items-table-body');
        if (!tbody.length) return;

        const rowCount = tbody.find('tr').length + 1;
        const row = `
            <tr>
                <td>${rowCount}</td>
                <td>${escHtml(item.name)}</td>
                <td>${escHtml(item.type)}</td>
                <td>${escHtml(item.reporter_name)}</td>
                <td>${escHtml(item.contact_no)}</td>
                <td>${escHtml(item.date)}</td>
                <td><span class="badge ${statusBadgeClass(item.status)}">${escHtml(item.status)}</span></td>
                <td>
                    <a href="/forms/${item.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                    <form action="/forms/${item.id}" method="POST" class="d-inline ajax-delete-item">
                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>`;
        tbody.append(row);

        // Remove "no items" placeholder row if present
        tbody.find('.no-items-row').remove();
    }

    /** Simple HTML escaping to prevent XSS in dynamically built rows */
    function escHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

});