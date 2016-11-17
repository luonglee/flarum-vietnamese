// Copyright © 2015 Toby Zerner and Flarum
// Copyright © 2015 Johann Rodríguez and Flarum en Español
// ---
// All rights reserved

import { extend } from 'flarum/extend';
import app from 'flarum/app';

import SpanishSettingsModal from 'flarumes/spanish/components/SpanishSettingsModal';

app.initializers.add('flarumes-spanish', app => {
  app.extensionSettings['flarumes-spanish'] = () => app.modal.show(new SpanishSettingsModal());
});
