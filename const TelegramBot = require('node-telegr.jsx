const TelegramBot = require('node-telegram-bot-api');

const token = 'YOUR_TELEGRAM_BOT_TOKEN';

const bot = new TelegramBot(token, { polling: true });

// Обработка команды /start
bot.onText(/\/start/, (msg, match) => {
  const chatId = msg.chat.id;
  const message = 'Выберите категорию:';

  const replyMarkup = {
    inline_keyboard: [
      [
        { text:'Категория 1', callback_data: 'category_1' },
        { text:'Категория 2', callback_data: 'category_2' }
      ],
      [
        { text:'Категория 3', callback_data: 'category_3' },
        { text:'Категория 4', callback_data: 'category_4' }
      ]
    ]
  };

  bot.sendMessage(chatId, message, { reply_markup: replyMarkup });
});


// Обработка callback-запросов от inline-клавиатуры
bot.on('callback_query', (query) => {
  const chatId = query.message.chat.id;
  const queryData = query.data;

  if (queryData === 'category_1') {
    const message = 'Вы выбрали Категория 1. Выберите подкатегорию:';

    const replyMarkup = {
      inline_keyboard: [
        [
          { text:'Подкатегория 1-1', callback_data: 'sub_category_1_1' },
          { text:'Подкатегория 1-2', callback_data: 'sub_category_1_2' }
        ],
        [
          { text:'Назад', callback_data: 'category_back' }
        ]
      ]
    };

    bot.editMessageText(message, { chat_id: chatId, message_id: query.message.message_id, reply_markup: replyMarkup });
  }

  else if (queryData === 'category_2') {
    const message = 'Вы выбрали Категория 2. Выберите подкатегорию:';

    const replyMarkup = {
      inline_keyboard: [
        [
          { text:'Подкатегория 2-1', callback_data: 'sub_category_2_1' },
          { text:'Подкатегория 2-2', callback_data: 'sub_category_2_2' }
        ],
        [
          { text:'Назад', callback_data: 'category_back' }
        ]
      ]
    };

    bot.editMessageText(message, { chat_id: chatId, message_id: query.message.message_id, reply_markup: replyMarkup });
  }

  else if (queryData === 'category_3') {
    const message = 'Вы выбрали Категория 3. Выберите подкатегорию:';

    const replyMarkup = {
      inline_keyboard: [
        [
          { text:'Подкатегория 3-1', callback_data: 'sub_category_3_1' },
          { text:'Подкатегория 3-2', callback_data: 'sub_category_3_2' }
        ],
        [
          { text:'Назад', callback_data: 'category_back' }
        ]
      ]
    };

    bot.editMessageText(message, { chat_id: chatId, message_id: query.message.message_id, reply_markup: replyMarkup });
  }

  else if (queryData === 'category_4') {
    const message = 'Вы выбрали Категория 4. Выберите подкатегорию:';

    const replyMarkup = {
      inline_keyboard: [
        [
          { text:'Подкатегория 4-1', callback_data: 'sub_category_4_1' },
          { text:'Подкатегория 4-2', callback_data: 'sub_category_4_2' }
        ],
        [
          { text:'Назад', callback_data: 'category_back' }
        ]
      ]
    };

    bot.editMessageText(message, { chat_id: chatId, message_id: query.message.message_id, reply_markup: replyMarkup });
  }

  else if (queryData === 'category_back') {
    const message = 'Выберите категорию:';

    const replyMarkup = {
      inline_keyboard: [
        [
          { text:'Категория 1', callback_data: 'category_1' },
          { text:'Категория 2', callback_data: 'category_2' }
        ],
        [
          { text:'Категория 3', callback_data: 'category_3' },
          { text:'Категория 4', callback_data: 'category_4' }
        ]
      ]
    };

    bot.editMessageText(message, { chat_id: chatId, message_id: query.message.message_id, reply_markup: replyMarkup });
  }

  else if (queryData === 'sub_category_1_1') {
    bot.sendMessage(chatId, 'Вы выбрали Категория 1 - Подкатегория 1-1');
  }

  else if (queryData === 'sub_category_1_2') {
    bot.sendMessage(chatId, 'Вы выбрали Категория 1 - Подкатегория 1-2');
  }

  else if (queryData === 'sub_category_2_1') {
    bot.sendMessage(chatId, 'Вы выбрали Категория 2 - Подкатегория 2-1');
  }

  else if (queryData === 'sub_category_2_2') {
    bot.sendMessage(chatId, 'Вы выбрали Категория 2 - Подкатегория 2-2');
  }

  else if (queryData === 'sub_category_3_1') {
    bot.sendMessage(chatId, 'Вы выбрали Категория 3 - Подкатегория 3-1');
  }

  else if (queryData === 'sub_category_3_2') {
    bot.sendMessage(chatId, 'Вы выбрали Категория 3 - Подкатегория 3-2');
  }

  else if (queryData === 'sub_category_4_1') {
    bot.sendMessage(chatId, 'Вы выбрали Категория 4 - Подкатегория 4-1');
  }

  else if (queryData === 'sub_category_4_2') {
    bot.sendMessage(chatId, 'Вы выбрали Категория 4 - Подкатегория 4-2');
  }
});