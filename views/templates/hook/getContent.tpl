{if isset($confirmation)}
    <div class="alert alert-success">Settings updated</div>
{/if}
<fieldset>
    <h2>My Module configuration</h2>
    <div class="panel">
        <div class="panel-heading">
            <legend><img src="../img/admin/cog.gif" alt="" width="16"
                />Configuration</legend>
        </div>
        <form action="" method="post">
            <div class="form-group clearfix">
                <label class="col-lg-3">Enable option:</label>
                <div class="col-lg-9">
                    <img src="../img/admin/enabled.gif" alt="" />
                    <input type="radio" id="enable_option_1" name="enable_option" value="1" {if $enable_option eq '1'}checked{/if}/>
                    <label class="t" for="enable_option_1">Yes</label>
                    <img src="../img/admin/disabled.gif" alt="" />
                    <input type="radio" id="enable_option_0" name="enable_option" value="0" {if empty($enable_option) || $enable_option eq '0'}checked{/if}/>
                    <label class="t" for="enable_option_0">No</label>
                </div>
            </div>
            <div class="panel-footer">
                <input class="btn btn-default pull-right" type="submit"
                       name="mymod_pc_form" value="Save" />
            </div>
            <div class="rte">
                {foreach $attribPrice as $attr}
                    <p>
                        <strong>Abcd {$attr.price}</strong>
                    </p><br>
                {/foreach}
            </div>
        </form>
    </div>
</fieldset>