<div class="imageselection">
<% if $Options %>
  <ul>
    <% loop $Options %>
        <li>
        <input id="{$ID}" class="radio" name="{$Name}" type="radio" value="{$Value}"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %><% if $Up.Required %> required<% end_if %>>
        <label for="{$ID}">
            <div class="image">
                {$Up.Thumbnail($Value)}
                <p class="title">{$Title}</p>
            </div>
        </label>
        </li>
    <% end_loop %>
  </ul>
<% else %>
    <p><%t NSWDPC\\Forms\ImageSelectionField\\ImageSelectionField.NO_OPTIONS_AVAILABLE 'No images available' %></p>
<% end_if %>
</div>
