<?php
/**
 * ダミーデータ生成ツール 管理画面
 */

// WordPress管理画面にメニューを追加
add_action('admin_menu', function() {
    add_menu_page(
        'ダミーデータ生成',           // ページタイトル
        'ダミーデータ',               // メニュータイトル
        'manage_options',            // 権限
        'dummy-generator',           // スラッグ
        'dummy_generator_page',      // コールバック関数
        'dashicons-database-add',    // アイコン
        30                          // 位置
    );
});

// 管理画面のページ内容
function dummy_generator_page() {
    ?>
    <div class="wrap">
        <h1>ダミーデータ生成ツール</h1>
        <p>ACF勉強会用のダミーデータを生成します。実行したいスクリプトを選択してください。</p>
        
        <div id="dummy-generator-container">
            <div class="card" style="max-width: 800px; margin-top: 20px;">
                <h2>実行可能なスクリプト</h2>
                
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th style="width: 150px;">スクリプト</th>
                            <th>説明</th>
                            <th style="width: 100px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>01. 基本投稿</strong></td>
                            <td>wp_insert_post()を使った基本的な投稿作成方法を学びます。シンプルな投稿、詳細設定付き、下書き投稿の作成例。</td>
                            <td>
                                <button class="button button-primary execute-script" data-script="01-basic-post.php">
                                    実行
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>02. 複数投稿</strong></td>
                            <td>ループ処理で複数投稿を効率的に作成。配列データからの生成、ランダムコンテンツ、親子関係のページ作成。</td>
                            <td>
                                <button class="button button-primary execute-script" data-script="02-multiple-posts.php">
                                    実行
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>03. タクソノミー</strong></td>
                            <td>カテゴリー・タグの作成と投稿への紐付け。階層構造のカテゴリー、タクソノミーベースの検索方法。</td>
                            <td>
                                <button class="button button-primary execute-script" data-script="03-taxonomy.php">
                                    実行
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>04. 画像処理</strong></td>
                            <td>メディアライブラリへの画像アップロード、アイキャッチ画像設定、本文への画像挿入、メタデータ管理。</td>
                            <td>
                                <button class="button button-primary execute-script" data-script="04-images.php">
                                    実行
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>05. ACF更新</strong></td>
                            <td>ACFの各種フィールドタイプ（テキスト、グループ、リピーター、フレキシブル、画像）の更新方法。</td>
                            <td>
                                <button class="button button-primary execute-script" data-script="05-acf-fields.php">
                                    実行
                                </button>
                            </td>
                        </tr>
                        <tr style="background-color: #f0f0f1;">
                            <td><strong>すべて実行</strong></td>
                            <td>上記のスクリプトをすべて順番に実行します。</td>
                            <td>
                                <button class="button button-secondary execute-all" data-script="generate.php">
                                    一括実行
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="card" style="max-width: 800px; margin-top: 20px;">
                <h2>実行結果</h2>
                <div id="execution-result" style="background: #1d2327; color: #00e100; padding: 15px; font-family: 'Courier New', monospace; min-height: 200px; max-height: 400px; overflow-y: auto; border-radius: 3px;">
                    <span style="color: #8b8b8b;">実行結果がここに表示されます...</span>
                </div>
                <div style="margin-top: 10px;">
                    <button class="button clear-result">結果をクリア</button>
                </div>
            </div>
            
            <div class="card" style="max-width: 800px; margin-top: 20px;">
                <h2>使い方</h2>
                <ol>
                    <li>実行したいスクリプトの「実行」ボタンをクリックします</li>
                    <li>処理が完了すると、実行結果に詳細が表示されます</li>
                    <li>複数のスクリプトを順番に実行することもできます</li>
                </ol>
                
                <h3>注意事項</h3>
                <ul>
                    <li>データベースに実際にデータが作成されます</li>
                    <li>テスト環境での使用を推奨します</li>
                    <li>作成されたデータは手動で削除する必要があります</li>
                </ul>
            </div>
        </div>
    </div>
    
    <style>
        .card {
            background: #fff;
            border: 1px solid #c3c4c7;
            box-shadow: 0 1px 1px rgba(0,0,0,0.04);
            padding: 20px;
        }
        .card h2 {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #c3c4c7;
        }
        #execution-result {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .execute-script:disabled,
        .execute-all:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // スクリプト実行
        $('.execute-script, .execute-all').on('click', function() {
            var button = $(this);
            var script = button.data('script');
            var originalText = button.text();
            
            // ボタンを無効化
            $('.execute-script, .execute-all').prop('disabled', true);
            button.text('実行中...');
            
            // 実行結果エリアに開始メッセージ
            $('#execution-result').append('\n\n' + '='.repeat(50) + '\n');
            $('#execution-result').append('実行開始: ' + script + '\n');
            $('#execution-result').append('='.repeat(50) + '\n\n');
            
            // AJAXリクエスト
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'execute_dummy_script',
                    script: script,
                    nonce: '<?php echo wp_create_nonce('dummy_generator_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        $('#execution-result').append(response.data.output);
                        $('#execution-result').append('\n✅ 完了\n');
                    } else {
                        $('#execution-result').append('❌ エラー: ' + response.data.message + '\n');
                    }
                    
                    // 自動スクロール
                    $('#execution-result').scrollTop($('#execution-result')[0].scrollHeight);
                },
                error: function() {
                    $('#execution-result').append('❌ 通信エラーが発生しました\n');
                },
                complete: function() {
                    // ボタンを有効化
                    $('.execute-script, .execute-all').prop('disabled', false);
                    button.text(originalText);
                }
            });
        });
        
        // 結果をクリア
        $('.clear-result').on('click', function() {
            $('#execution-result').html('<span style="color: #8b8b8b;">実行結果がここに表示されます...</span>');
        });
    });
    </script>
    <?php
}

// AJAX処理
add_action('wp_ajax_execute_dummy_script', 'handle_dummy_script_execution');

function handle_dummy_script_execution() {
    // nonce検証
    if (!wp_verify_nonce($_POST['nonce'], 'dummy_generator_nonce')) {
        wp_send_json_error(['message' => '不正なリクエストです']);
        return;
    }
    
    // 権限確認
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => '権限がありません']);
        return;
    }
    
    $script = sanitize_text_field($_POST['script']);
    $allowed_scripts = [
        '01-basic-post.php',
        '02-multiple-posts.php',
        '03-taxonomy.php',
        '04-images.php',
        '05-acf-fields.php',
        'generate.php'
    ];
    
    if (!in_array($script, $allowed_scripts)) {
        wp_send_json_error(['message' => '許可されていないスクリプトです']);
        return;
    }
    
    $script_path = get_template_directory() . '/dummy-generator/' . $script;
    
    if (!file_exists($script_path)) {
        wp_send_json_error(['message' => 'スクリプトファイルが見つかりません']);
        return;
    }
    
    // 出力バッファリング開始
    ob_start();
    
    try {
        // スクリプトを実行
        include $script_path;
        
        $output = ob_get_clean();
        
        wp_send_json_success(['output' => $output]);
    } catch (Exception $e) {
        ob_end_clean();
        wp_send_json_error(['message' => 'エラー: ' . $e->getMessage()]);
    }
}