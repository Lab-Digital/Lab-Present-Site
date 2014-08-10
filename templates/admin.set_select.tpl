{if (isset($item_id) || isset($last_viewed_id))}
  <script>
    {if isset($item_id)}{literal}
      if ($('#choose_item option[value="{/literal}{$item_id}{literal}"]').length > 0) {
        $('#choose_item option[value="{/literal}{$item_id}{literal}"]').attr('selected','selected');
      }
    {/literal}{elseif isset($last_viewed_id)}{literal}
      $('#choose_item option[value="{/literal}{$last_viewed_id}{literal}"]').attr('selected','selected');
    {/literal}{/if}{literal}
      $('#choose_item').change();
    {/literal}
  </script>
{/if}