<div id="doctext-display">
    <h2><?php echo __('Document Texts'); ?></h2>

    <table>
        <?php foreach ($files as $filename => $html): ?>
        <tr>
            <td><?php echo __('File Contents'); ?></td>
            <td><span title="<?php echo html_escape($filename); ?>"><?php echo $html; ?></span></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
