<%var items = cart.items();var settings = cart.settings();var hasItems = !!items.length;var priceFormat = { format: true, currency: cart.settings("currency_code") };var totalFormat = { format: true, showCode: true };%>

<form method="post" class="<% if (!hasItems) { %>minicarts-empty<% } %>" action="<%= config.action %>" target="<%= config.target %>">
    <button type="button" class="minicarts-closer">&times;</button>
    <ul>
        <% for (var i= 0, idx = i + 1, len = items.length; i < len; i++, idx++) { %>
        <li class="minicarts-item">
            <div class="minicarts-details-name">
                <a class="minicarts-name" href="<%= items[i].get('href') %>">
                    <%= items[i].get("item_name") %>
                </a>
                <ul class="minicarts-attributes">
                    <% if (items[i].get("item_number")) { %>
                    <li>
                        <%= items[i].get("item_number") %>
                        <input type="hidden" name="item_number_<%= idx %>" value="<%= items[i].get('item_number') %>" />
                    </li>
                    <% } %>
                    <% if (items[i].discount()) { %>
                    <li>
                        <%= config.strings.discount %>
                        <%= items[i].discount(priceFormat) %>
                        <input type="hidden" name="discount_amount_<%= idx %>" value="<%= items[i].discount() %>" />
                    </li>
                    <% } %>
                    <% for (var options = items[i].options(), j = 0, len2 = options.length; j < len2; j++) { %>
                    <li>
                        <%= options[j].key %>: <%= options[j].value %>
                        <input type="hidden" name="on<%= j %>_<%= idx %>" value="<%= options[j].key %>" />
                        <input type="hidden" name="os<%= j %>_<%= idx %>" value="<%= options[j].value %>" />
                    </li>
                    <% } %>
                </ul>
            </div>
            <div class="minicarts-details-quantity">
                <input class="minicarts-quantity" data-minicarts-idx="<%= i %>" name="quantity_<%= idx %>" type="text" pattern="[0-9]*" value="<%= items[i].get('quantity') %>" autocomplete="off" />
            </div>
            <div class="minicarts-details-remove">
                <button type="button" class="minicarts-remove" data-minicarts-idx="<%= i %>">&times;</button>
            </div>
            <div class="minicarts-details-price">
                <span class="minicarts-price"><%= items[i].total(priceFormat) %></span>
            </div>
            <input type="hidden" name="id_produk_<%= idx %>" value="<%= items[i].get('id_produk') %>" />
            <input type="hidden" name="item_name_<%= idx %>" value="<%= items[i].get('item_name') %>" />
            <input type="hidden" name="amount_<%= idx %>" value="<%= items[i].amount() %>" />
            <input type="hidden" name="shipping_<%= idx %>" value="<%= items[i].get('shipping') %>" />
            <input type="hidden" name="shipping2_<%= idx %>" value="<%= items[i].get('shipping2') %>" />
        </li>
        <% } %>
    </ul>
    <div class="minicarts-footer">
        <% if (hasItems) { %>
        <div class="minicarts-subtotal">
            <%= config.strings.subtotal %> <%= cart.total(totalFormat) %>
        </div>
        <button class="minicarts-submit" type="submit" data-minicarts-alt="<%= config.strings.buttonAlt %>"><%- config.strings.button %></button>
        <% } else { %>
        <p class="minicarts-empty-text"><%= config.strings.empty %></p>
        <% } %>
    </div>
    <input type="hidden" name="cmd" value="_cart" />
    <input type="hidden" name="upload" value="1" />
    <% for (var key in settings) { %>
    <input type="hidden" name="<%= key %>" value="<%= settings[key] %>" /> <% } %>
</form>



<form method="post" class="<?= (!$item) ? 'minicarts-empty' : '';  ?>" action="<?= base_url() ?>/chekout">
    <button type="button" class="minicarts-closer">&times;</button>
    <ul>
        <?php $number = 1; ?>
        <?php foreach ($item as $i) : ?>
            <li class="minicarts-item">
                <div class="minicarts-details-name">
                    <a class="minicarts-name" href="#">
                        <?= $i['nama_produk']; ?>
                    </a>
                    <ul class="minicarts-attributes">
                        <li>
                            <?= $number++ ?>
                            <input type="hidden" name="item_number" value="<?= $number++; ?>" />
                        </li>
                        <?php if ($i['diskon']) : ?>
                            <li>
                                Discount <?= $i['diskon']; ?>
                                <input type="hidden" name="diskon_<?= $i['id_produk'] ?>" value="<?= $i['diskon']; ?>" />
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="minicarts-details-quantity">
                    <input class="minicarts-quantity" name="quantity_<?= $i['id_produk'] ?>" type="number" pattern="[0-9]*" value="<?= $i['kuantitas']; ?>" autocomplete="off" />
                </div>
                <div class="minicarts-details-remove">
                    <button type="button" id="delete-keranjang" class="minicarts-remove" onclick="delkeranjang()">&times;</button>
                </div>
                <div class="minicarts-details-price">
                    <span class="minicarts-price"><%= items[i].total(priceFormat) %></span>
                </div>
                <input type="hidden" name="item_name_<%= idx %>" value="<%= items[i].get('item_name') %>" />
                <input type="hidden" name="amount_<%= idx %>" value="<%= items[i].amount() %>" />
                <input type="hidden" name="shipping_<%= idx %>" value="<%= items[i].get('shipping') %>" />
                <input type="hidden" name="shipping2_<%= idx %>" value="<%= items[i].get('shipping2') %>" />
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="minicarts-footer">
        <% if (hasItems) { %>
        <div class="minicarts-subtotal">
            <%= config.strings.subtotal %> <%= cart.total(totalFormat) %>
        </div>
        <button class="minicarts-submit" type="submit" data-minicarts-alt="<%= config.strings.buttonAlt %>"><%- config.strings.button %></button>
        <% } else { %>
        <p class="minicarts-empty-text"><%= config.strings.empty %></p>
        <% } %>
    </div>
    <input type="hidden" name="cmd" value="_cart" />
    <input type="hidden" name="upload" value="1" />
    <% for (var key in settings) { %>
    <input type="hidden" name="<%= key %>" value="<%= settings[key] %>" /> <% } %>
</form>

<script>

</script>