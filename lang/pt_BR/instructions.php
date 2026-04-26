<?php

return [
    'sections' => [

        'account' => [
            'title' => 'Conta',
            'description' => 'Você pode atualizar o email e a senha da sua conta seguindo os passos abaixo. As alterações são aplicadas imediatamente após salvar.',

            'step_1' => [
                'title' => 'Acesse a página de configurações',
                'description' => 'Clique no menu da conta (canto superior direito) e selecione a opção ',
                'account_label' => 'Conta',
            ],

            'step_2' => [
                'title' => 'Atualize seu Email ou Senha',
                'description' => 'Na seção de configurações, você encontrará os campos para alterar seu email e senha. Após preencher os novos dados, clique em ',
                'save_label' => 'Salvar',
            ],

        ],

        'how_to_play' => [
            'title' => 'Como fazer uma aposta',
            'description' => 'Nesta seção você aprende como criar, editar e remover seu palpite, além de entender quando ele fecha e como o sistema confirma a ação.',

            'labels' => [
                'mobile' => 'Mobile',
                'desktop' => 'Desktop',
                'messages_examples' => 'Exemplos de mensagens',
            ],

            'step_1' => [
                'title' => 'Criar um palpite antes do início',
                'description' => 'Você pode apostar até o início da partida. Para criar o palpite, clique na partida desejada e ajuste o placar usando os botões de ',
                'mobile_hint' => 'Screenshot mobile - selecionar partida e ajustar placar',
                'desktop_hint' => 'Screenshot desktop - selecionar partida e ajustar placar',
            ],

            'step_2' => [
                'title' => 'Editar ou remover um palpite existente',
                'description' => 'Se você já tiver um placar salvo e quiser alterar, basta ajustar os valores novamente e clicar em salvar. Se quiser remover o palpite, clique em remover.',
                'save_label' => 'Salvar',
                'remove_label' => 'Remover',
                'mobile_hint' => 'Screenshot mobile - salvar / remover palpite',
                'desktop_hint' => 'Screenshot desktop - salvar / remover palpite',
            ],

            'step_3' => [
                'title' => 'Confirmação e possíveis erros',
                'description' => 'Ao salvar ou remover um palpite, você verá uma mensagem de sucesso ou falha. Se ocorrer algum erro, tente novamente mais tarde.',
                'success_example' => 'Palpite salvo com sucesso',
                'error_example' => 'Não foi possível salvar agora. Tente novamente.',
            ],
        ],

        'ranking' => [
            'title' => 'Ranking',
            'description' => 'O ranking é atualizado automaticamente com base nos palpites validados. Abaixo explicamos como os pontos são calculados e quando a classificação é atualizada.',

            'step_1' => [
                'title' => 'Como os pontos são calculados',
                'intro' => 'Cada palpite validado gera uma pontuação baseada na precisão do resultado:',

                'points' => [
                    ['label' => '7 pontos', 'description' => 'Placar exato'],
                    ['label' => '5 pontos', 'description' => 'Time vencedor + gols de algum dos times'],
                    ['label' => '3 pontos', 'description' => 'Time vencedor ou empate'],
                    ['label' => '2 pontos', 'description' => 'Gols de um dos times'],
                    ['label' => '0 pontos', 'description' => 'Não acertou nada'],
                ],

                'example_title' => 'Exemplo prático',
                'example' => [
                    'bet' => 'Palpite',
                    'final_result' => 'Resultado Final',
                ],
            ],

            'step_2' => [
                'title' => 'Quando os cálculos são realizados',
                'description' => 'A pontuação é calculada automaticamente após a validação oficial do resultado da partida. Assim que o resultado é confirmado no sistema, os pontos são atribuídos e o ranking é atualizado.',

                'auto_update_title' => 'Atualização automática',
                'auto_update_description' => 'O ranking pode ser atualizado imediatamente após a validação do jogo. Caso haja algum atraso na validação, a pontuação será ajustada automaticamente assim que o resultado for confirmado.',
            ],
        ],

    ],

    'ui' => [
        'guide_button' => 'Guia',
        'slideover' => [
            'heading' => 'Guia Completo',
            'description' => 'Seções com instruções de como usar o sistema e jogar o bolão.',
        ],
    ],
];
