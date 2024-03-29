<?php
/**
 * Dokan Withdraw Pending Request Listing Template for dashboard
 *
 * @since   3.3.1
 *
 * @var $withdraw_requests \WeDevs\Dokan\Withdraw\Withdraw[]
 *
 * @package dokan
 */

if ( $withdraw_requests ) :
    ?>
    <div class="dokan-clearfix dokan-panel-inner-container">
        <div class="dokan-w12">
            <strong><?php esc_html_e( 'Pending Requests', 'dokan-lite' ); ?></strong>
            <table class="dokan-table dokan-table-striped">
                <tr>
                    <th><?php esc_html_e( 'Amount', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Method', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Date', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Charge', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Receivable', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Cancel', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Status', 'dokan-lite' ); ?></th>
                </tr>

                <?php foreach ( $withdraw_requests as $request ) : ?>
                    <tr>
                        <td><?php echo wp_kses_post( wc_price( $request->get_amount() ) ); ?></td>
                        <td><?php echo esc_html( dokan_withdraw_get_method_title( $request->get_method() ) ); ?></td>
                        <td><?php echo esc_html( dokan_format_datetime( $request->get_date() ) ); ?></td>
                        <td><?php echo wp_kses_post( wc_price( $request->get_charge() ) ); ?></td>
                        <td><?php echo wp_kses_post( wc_price( $request->get_receivable_amount() ) ); ?></td>
                        <td>
                            <?php
                            $url = add_query_arg(
                                [
                                    'dokan_handle_withdraw_request' => 'cancel',
                                    'id'                            => $request->get_id(),
                                ],
                                dokan_get_navigation_url( 'withdraw-requests' )
                            );
                            ?>
                            <a href="<?php echo esc_url( wp_nonce_url( $url, 'dokan_cancel_withdraw' ) ); ?>">
                                <?php esc_html_e( 'Cancel', 'dokan-lite' ); ?>
                            </a>
                        </td>
                        <td>
                            <?php
                            if ( intval( $request->get_status() ) === 0 ) {
                                echo '<span class="label label-danger">' . esc_html__( 'Pending Review', 'dokan-lite' ) . '</span>';
                            } elseif ( intval( $request->get_status() ) === 1 ) {
                                echo '<span class="label label-warning">' . esc_html__( 'Accepted', 'dokan-lite' ) . '</span>';
                            }
                            ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </table>
        </div>
    </div>
    <?php
endif;
