<?php
require 'includes/guard.php';
require_role(['admin', 'staff']);
require 'includes/admin_helpers.php';
require 'includes/admin_layout.php';

$isStaff = ($_SESSION['role'] ?? '') === 'staff';
$sampleProducts = [
    ['sku' => 'UNI-101', 'name' => 'Royal Blue — 100% Cotton Twill Coverall (Reflectorized)', 'category' => 'Uniforms', 'price' => '₱1,000', 'stock' => 24, 'threshold' => 8, 'status' => 'Visible', 'icon' => 'fa-shirt', 'tone' => 'navy'],
    ['sku' => 'UNI-102', 'name' => 'Orange — 100% Cotton Twill Coverall (Reflectorized)', 'price' => '₱1,000', 'stock' => 6, 'threshold' => 10, 'status' => 'Visible', 'icon' => 'fa-person', 'tone' => 'sand'],
    ['sku' => 'PPE-001', 'name' => 'Chef''s Polo Long Sleeve', 'price' => '₱800', 'stock' => 18, 'threshold' => 8, 'status' => 'Visible', 'icon' => 'fa-vest', 'tone' => 'yellow'],
    ['sku' => 'CRW-010', 'name' => 'Kitchen Crew Polo', 'category' => 'Safety Footwear', 'price' => '₱800', 'stock' => 3, 'threshold' => 6, 'status' => 'Visible', 'icon' => 'fa-shoe-prints', 'tone' => 'green'],
    ['sku' => 'PPE-002', 'name' => 'Chef Pants', 'category' => 'PPE & Safety', 'price' => '₱500', 'stock' => 0, 'threshold' => 5, 'status' => 'Out of stock', 'icon' => 'fa-helmet-safety', 'tone' => 'red'],
    ['sku' => 'JCK-020', 'name' => 'Winter Jacket - Reflectorized', 'category' => 'Accessories', 'price' => '₱1,500', 'stock' => 12, 'threshold' => 4, 'status' => 'Hidden', 'icon' => 'fa-hat-cowboy', 'tone' => 'sand']
];

admin_layout_start('Inventory Workspace Preview', 'products');
?>
<section class="inventory-intro">
    <div>
        <p class="inventory-eyebrow">Product workspace / design preview</p>
        <h2>Inventory control</h2>
        <p>Manage catalog visibility, monitor stock levels and plan restocks from one workspace.</p>
    </div>
    <span class="inventory-preview-label"><i class="fa-solid fa-eye"></i> Design preview · changes are not saved</span>
</section>

<section class="inventory-metrics" aria-label="Illustrative inventory metrics">
    <article class="inventory-metric"><span>Catalog products</span><strong>12</strong><small><i class="fa-solid fa-box"></i> Illustrative example</small></article>
    <article class="inventory-metric"><span>Low stock</span><strong class="metric-warning">02</strong><small><i class="fa-solid fa-triangle-exclamation"></i> At or below reorder level</small></article>
    <article class="inventory-metric"><span>Out of stock</span><strong class="metric-danger">01</strong><small><i class="fa-solid fa-circle-exclamation"></i> Needs replenishment</small></article>
    <article class="inventory-metric"><span>Inventory value</span><strong>₱84,520</strong><small><i class="fa-solid fa-coins"></i> Sample estimate only</small></article>
</section>

<section class="inventory-panel">
    <div class="inventory-toolbar">
        <div>
            <p class="inventory-eyebrow">Catalog management</p>
            <h2>Products &amp; stock</h2>
        </div>
        <button type="button" class="admin-action-button" disabled title="Preview only; product actions are not connected yet">
            <i class="fa-solid fa-plus"></i>&nbsp; Add product
        </button>
    </div>
    <div class="inventory-filterbar">
        <label class="inventory-search"><i class="fa-solid fa-magnifying-glass"></i><input id="productSearch" type="search" placeholder="Search product or SKU" aria-label="Search products"></label>
        <label class="inventory-select">Category
            <select id="categoryFilter" aria-label="Filter by category">
                <option value="all">All categories</option>
                <option>Maritime Uniforms</option><option>PPE &amp; Safety</option><option>Safety Footwear</option><option>Accessories</option>
            </select>
        </label>
        <label class="inventory-select">Stock status
            <select id="stockFilter" aria-label="Filter by stock status">
                <option value="all">All stock</option><option value="low">Low stock</option><option value="out">Out of stock</option><option value="healthy">Healthy</option>
            </select>
        </label>
    </div>

    <div class="inventory-table-wrap">
        <table class="inventory-table">
            <thead><tr><th>Product</th><th>Category</th><th>Price</th><th>Stock level</th><th>Visibility</th><th>Actions</th></tr></thead>
            <tbody id="productRows">
            <?php foreach ($sampleProducts as $product):
                $lowStock = $product['stock'] > 0 && $product['stock'] <= $product['threshold'];
                $stockType = $product['stock'] === 0 ? 'out' : ($lowStock ? 'low' : 'healthy');
                $stockText = $product['stock'] === 0 ? 'Out of stock' : ($lowStock ? 'Low stock' : 'In stock');
                $visibilityClass = $product['status'] === 'Visible' ? 'visible' : ($product['status'] === 'Hidden' ? 'hidden' : 'out');
            ?>
                <tr data-name="<?= admin_escape(strtolower($product['name'] . ' ' . $product['sku'])) ?>" data-category="<?= admin_escape($product['category']) ?>" data-stock="<?= $stockType ?>">
                    <td data-label="Product">
                        <div class="inventory-product">
                            <span class="inventory-product-icon tone-<?= admin_escape($product['tone']) ?>"><i class="fa-solid <?= admin_escape($product['icon']) ?>"></i></span>
                            <span><strong><?= admin_escape($product['name']) ?></strong><small><?= admin_escape($product['sku']) ?></small></span>
                        </div>
                    </td>
                    <td data-label="Category"><?= admin_escape($product['category']) ?></td>
                    <td data-label="Price"><strong><?= admin_escape($product['price']) ?></strong></td>
                    <td data-label="Stock">
                        <div class="stock-cell"><strong><?= (int)$product['stock'] ?></strong><span><?= $product['stock'] === 0 ? 'units' : 'units' ?></span></div>
                        <div class="stock-track"><i class="stock-fill <?= $stockType ?>" style="width:<?= min(100, max(5, (int)$product['stock'] * 4)) ?>%"></i></div>
                        <span class="stock-status <?= $stockType ?>"><?= $stockText ?> · reorder at <?= (int)$product['threshold'] ?></span>
                    </td>
                    <td data-label="Visibility"><span class="visibility-badge <?= $visibilityClass ?>"><?= admin_escape($product['status']) ?></span></td>
                    <td data-label="Actions">
                        <div class="inventory-actions">
                            <button type="button" class="icon-action" aria-label="View <?= admin_escape($product['name']) ?>" title="View details"><i class="fa-regular fa-eye"></i></button>
                            <button type="button" class="icon-action" aria-label="Edit <?= admin_escape($product['name']) ?>" title="Preview only; editing is not connected" disabled><i class="fa-regular fa-pen-to-square"></i></button>
                            <button type="button" class="icon-action stock-action" aria-label="Update stock for <?= admin_escape($product['name']) ?>" title="Preview only; stock updates are not connected" disabled><i class="fa-solid fa-boxes-stacked"></i></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="inventory-empty" id="emptyProducts" hidden>No products match these filters.</div>
    </div>
    <div class="inventory-table-footer"><span>Illustrative records · not connected to a product database</span><span>Showing sample inventory</span></div>
</section>

<section class="inventory-lower-grid">
    <article class="inventory-panel reorder-panel">
        <div class="inventory-subheading"><div><p class="inventory-eyebrow">Action required</p><h2>Restock attention</h2></div><span class="restock-count">3 items</span></div>
        <div class="restock-row"><span class="restock-icon danger"><i class="fa-solid fa-shoe-prints"></i></span><div><strong>Steel-Toe Deck Boots</strong><small>Only 3 pairs · reorder level 6</small></div><span class="restock-tag urgent">Urgent</span></div>
        <div class="restock-row"><span class="restock-icon warning"><i class="fa-solid fa-person"></i></span><div><strong>Engine Room Coverall</strong><small>Only 6 units · reorder level 10</small></div><span class="restock-tag soon">Restock soon</span></div>
        <div class="restock-row"><span class="restock-icon danger"><i class="fa-solid fa-helmet-safety"></i></span><div><strong>Marine Safety Helmet</strong><small>Out of stock · reorder level 5</small></div><span class="restock-tag urgent">Urgent</span></div>
    </article>
    <article class="inventory-panel stock-note">
        <span class="stock-note-icon"><i class="fa-solid fa-clipboard-check"></i></span>
        <p class="inventory-eyebrow">Staff access</p>
        <h2>Stock operations, with limits</h2>
        <p>This preview shows how product and restock controls can look. Staff can review stock and plan replenishment here; product edits and stock changes are disabled in this design-only page.</p>
        <div class="stock-note-rule"><i class="fa-solid fa-lock"></i> No product database connected · no actions are saved</div>
    </article>
</section>

<div class="inventory-footer"><a class="admin-action-button secondary" href="<?= $isStaff ? 'staff_dashboard.php' : 'admin_dashboard.php' ?>"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back to dashboard</a><span>Design workspace only · sample figures are illustrative</span></div>

<style>
css
```
.inventory-intro,
.inventory-toolbar,
.inventory-subheading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
}

.inventory-intro {
    align-items: end;
    margin-bottom: 22px;
}

.inventory-intro h2,
.inventory-toolbar h2,
.inventory-subheading h2,
.stock-note h2 {
    margin: 0 0 6px;
    font-size: clamp(1.7rem, 3vw, 2.35rem);
}

.inventory-intro > div > p:last-child,
.stock-note > p:not(.inventory-eyebrow) {
    max-width: 700px;
    color: var(--text-muted);
    line-height: 1.6;
}

.inventory-eyebrow {
    margin-bottom: 5px;
    color: var(--text-muted);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.inventory-preview-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    color: #665000;
    background: #fff2bb;
    border: 1px solid #ead77b;
    border-radius: 22px;
    font-size: 0.76rem;
    font-weight: 700;
    white-space: nowrap;
}

[data-theme="dark"] .inventory-preview-label {
    color: #ffe88a;
    background: #433a20;
    border-color: #75652e;
}

.inventory-metrics {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 20px;
}

.inventory-metric,
.inventory-panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}

.inventory-metric {
    min-height: 132px;
    padding: 18px;
}

.inventory-metric > span,
.inventory-metric small {
    display: block;
    color: var(--text-muted);
}

.inventory-metric > strong {
    display: block;
    margin: 8px 0 6px;
    color: var(--navy);
    font: 2rem 'Bebas Neue Custom', sans-serif;
}

[data-theme="dark"] .inventory-metric > strong {
    color: var(--yellow);
}

.inventory-metric > strong.metric-warning {
    color: #a57b00;
}

.inventory-metric > strong.metric-danger {
    color: var(--red);
}

.inventory-metric small {
    font-size: 0.74rem;
}

.inventory-metric small i {
    margin-right: 4px;
}

.inventory-panel {
    padding: clamp(17px, 2.4vw, 24px);
}

.inventory-toolbar {
    margin-bottom: 19px;
}

.inventory-toolbar .admin-action-button {
    gap: 4px;
}

.inventory-filterbar {
    display: flex;
    align-items: end;
    gap: 10px;
    margin-bottom: 16px;
}

.inventory-search,
.inventory-select {
    display: grid;
    gap: 6px;
    color: var(--text-muted);
    font-size: 0.78rem;
    font-weight: 700;
}

.inventory-search {
    position: relative;
    flex: 1 1 280px;
}

.inventory-search i {
    position: absolute;
    top: 14px;
    left: 13px;
    color: var(--text-muted);
}

.inventory-search input,
.inventory-select select {
    min-height: 44px;
    padding: 10px 12px;
    color: var(--text);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    font: inherit;
}

.inventory-search input {
    padding-left: 38px;
}

.inventory-select {
    flex: 0 1 200px;
}

.inventory-table-wrap {
    overflow-x: auto;
}

.inventory-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.inventory-table th {
    padding: 12px 11px;
    color: var(--text-muted);
    background: var(--bg);
    font-size: 0.68rem;
    letter-spacing: 0.07em;
    text-transform: uppercase;
}

.inventory-table td {
    padding: 14px 11px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
    font-size: 0.82rem;
}

.inventory-product {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 190px;
}

.inventory-product > span:last-child {
    display: grid;
    gap: 4px;
}

.inventory-product small {
    color: var(--text-muted);
    font-size: 0.7rem;
}

.inventory-product-icon {
    display: grid;
    place-items: center;
    width: 43px;
    height: 43px;
    flex: 0 0 auto;
    color: var(--navy);
    border-radius: 11px;
    font-size: 1.05rem;
}

.tone-navy {
    background: #e5edf4;
}

.tone-sand {
    background: #f1eadc;
}

.tone-yellow {
    background: #fff2bb;
}

.tone-green {
    background: #e2eee7;
}

.tone-red {
    background: #fbe4e6;
}

[data-theme="dark"] .inventory-product-icon {
    color: var(--text);
}

.stock-cell {
    display: flex;
    align-items: baseline;
    gap: 5px;
}

.stock-cell strong {
    font-size: 1rem;
}

.stock-cell span,
.stock-status {
    color: var(--text-muted);
    font-size: 0.68rem;
}

.stock-track {
    width: 110px;
    height: 5px;
    margin: 5px 0;
    overflow: hidden;
    background: var(--bg);
    border-radius: 5px;
}

.stock-fill {
    display: block;
    height: 100%;
    background: var(--green);
    border-radius: 5px;
}

.stock-fill.low {
    background: #e0a900;
}

.stock-fill.out {
    background: var(--red);
}

.stock-status {
    display: block;
}

.stock-status.low {
    color: #a57b00;
}

.stock-status.out {
    color: var(--red);
}

.visibility-badge,
.restock-tag {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 15px;
    font-size: 0.68rem;
    font-weight: 700;
    white-space: nowrap;
}

.visibility-badge.visible {
    color: var(--green);
    background: #e4f0e9;
}

.visibility-badge.hidden {
    color: #646464;
    background: #ececea;
}

.visibility-badge.out {
    color: #a82b35;
    background: #fbe4e6;
}

[data-theme="dark"] .visibility-badge.visible {
    color: #a9e3bf;
    background: #244437;
}

[data-theme="dark"] .visibility-badge.hidden {
    color: #d0d0c8;
    background: #334253;
}

[data-theme="dark"] .visibility-badge.out {
    color: #ffb7bf;
    background: #4c2831;
}

.inventory-actions {
    display: flex;
    gap: 5px;
}

.icon-action {
    display: grid;
    place-items: center;
    width: 36px;
    height: 36px;
    color: var(--text-muted);
    background: transparent;
    border: 1px solid var(--border);
    border-radius: 9px;
}

.icon-action:disabled,
.inventory-toolbar button:disabled {
    opacity: 0.42;
    cursor: not-allowed;
}

.icon-action.stock-action {
    color: var(--navy);
}

.inventory-empty {
    padding: 24px;
    color: var(--text-muted);
    text-align: center;
}

.inventory-table-footer {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding-top: 13px;
    color: var(--text-muted);
    font-size: 0.72rem;
}

.inventory-lower-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 16px;
    margin-top: 18px;
}

.inventory-subheading {
    margin-bottom: 9px;
}

.inventory-subheading h2 {
    font-size: 1.55rem;
}

.restock-count {
    padding: 6px 10px;
    color: #a82b35;
    background: #fbe4e6;
    border-radius: 15px;
    font-size: 0.72rem;
    font-weight: 700;
}

.restock-row {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 13px 0;
    border-top: 1px solid var(--border);
}

.restock-icon {
    display: grid;
    place-items: center;
    width: 38px;
    height: 38px;
    flex: 0 0 auto;
    border-radius: 10px;
}

.restock-icon.danger {
    color: #a82b35;
    background: #fbe4e6;
}

.restock-icon.warning {
    color: #856700;
    background: #fff2bb;
}

.restock-row > div {
    flex: 1;
}

.restock-row strong,
.restock-row small {
    display: block;
}

.restock-row strong {
    font-size: 0.84rem;
}

.restock-row small {
    margin-top: 4px;
    color: var(--text-muted);
    font-size: 0.72rem;
}

.restock-tag.urgent {
    color: #a82b35;
    background: #fbe4e6;
}

.restock-tag.soon {
    color: #856700;
    background: #fff2bb;
}

.stock-note {
    position: relative;
    overflow: hidden;
}

.stock-note-icon {
    display: grid;
    place-items: center;
    width: 44px;
    height: 44px;
    margin-bottom: 14px;
    color: var(--yellow);
    background: var(--navy);
    border-radius: 13px;
    font-size: 1.15rem;
}

.stock-note h2 {
    font-size: 1.65rem;
}

.stock-note > p:not(.inventory-eyebrow) {
    margin: 12px 0 17px;
    font-size: 0.86rem;
}

.stock-note-rule {
    padding: 12px;
    color: var(--text-muted);
    background: var(--bg);
    border-radius: 9px;
    font-size: 0.74rem;
}

.stock-note-rule i {
    margin-right: 6px;
    color: var(--navy);
}

[data-theme="dark"] .stock-note-rule i {
    color: var(--yellow);
}

.inventory-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-top: 18px;
    color: var(--text-muted);
    font-size: 0.75rem;
}

@media (max-width: 1050px) {
    .inventory-metrics {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .inventory-lower-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 760px) {
    .inventory-filterbar {
        align-items: stretch;
        flex-direction: column;
    }

    .inventory-select {
        flex: 1;
    }

    .inventory-table thead {
        display: none;
    }

    .inventory-table,
    .inventory-table tbody,
    .inventory-table tr,
    .inventory-table td {
        display: block;
        width: 100%;
    }

    .inventory-table tr {
        margin-bottom: 12px;
        padding: 9px 12px;
        border: 1px solid var(--border);
        border-radius: 12px;
    }

    .inventory-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 9px 0;
        border: 0;
    }

    .inventory-table td::before {
        flex: 0 0 85px;
        color: var(--text-muted);
        content: attr(data-label);
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .inventory-table td:first-child {
        justify-content: flex-start;
    }

    .inventory-table td:first-child::before {
        display: none;
    }

    .inventory-actions {
        margin-left: auto;
    }

    .inventory-table-footer {
        flex-direction: column;
    }
}

@media (max-width: 560px) {
    .inventory-intro,
    .inventory-toolbar {
        align-items: flex-start;
        flex-direction: column;
    }

    .inventory-preview-label {
        white-space: normal;
    }

    .inventory-metrics {
        gap: 9px;
    }

    .inventory-metric {
        min-height: 120px;
        padding: 13px;
    }

    .inventory-metric > strong {
        font-size: 1.7rem;
    }

    .inventory-footer {
        align-items: flex-start;
        flex-direction: column;
    }

    .restock-row {
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .restock-tag {
        margin-left: 49px;
    }
}
</style>

<script>
    (function () {
        var search = document.getElementById('productSearch');
        var category = document.getElementById('categoryFilter');
        var stock = document.getElementById('stockFilter');
        var rows = Array.prototype.slice.call(document.querySelectorAll('#productRows tr'));
        var empty = document.getElementById('emptyProducts');

        function filterRows() {
            var searchText = search.value.trim().toLowerCase();
            var shown = 0;
            rows.forEach(function (row) {
                var matchesSearch = row.dataset.name.indexOf(searchText) !== -1;
                var matchesCategory = category.value === 'all' || row.dataset.category === category.value;
                var matchesStock = stock.value === 'all' || row.dataset.stock === stock.value;
                row.hidden = !(matchesSearch && matchesCategory && matchesStock);
                if (!row.hidden) shown++;
            });
            empty.hidden = shown > 0;
        }

        search.addEventListener('input', filterRows);
        category.addEventListener('change', filterRows);
        stock.addEventListener('change', filterRows);
    })();
</script>
<?php admin_layout_end(); ?>
