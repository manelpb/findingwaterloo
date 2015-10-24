 private ArrayList<MusicData> getTrackDataFromJson(String musicJsonStr)
                throws JSONException {
            ArrayList<MusicData> music;
            String trackName;
            String albumName;
            String albumImage640;
            String albumImage300;
            String previewUrl;
            String external_urls;
            int NUMBER_OF_DISPLAY_TRACK = 10;

            //Log.v(LOG_TAG, "artisList JSON String"+musicJsonStr);

            // These are the names of the JSON objects that need to be extracted.
            final String SPOTIFY_TRACKS = "tracks";
            final String SPOTIFY_ID = "id";
            final String SPOTIFY_IMAGE = "images";
            JSONObject musicJson = new JSONObject(musicJsonStr);
            JSONArray musicArray = musicJson.getJSONArray(SPOTIFY_TRACKS);
            //Log.v(LOG_TAG, "artisList JSON String"+musicArray.toString());
            int numberOfAritist = musicArray.length();

            if (numberOfAritist < NUMBER_OF_DISPLAY_TRACK) {
                NUMBER_OF_DISPLAY_TRACK = numberOfAritist;    //by any chance if top tracks are less than 10 will result at out of boundary
            }

            music = new ArrayList<MusicData>();

            for (int i = 0; i < NUMBER_OF_DISPLAY_TRACK; i++) {
                final String OWM_ALBUM = "album";
                final String OWM_URL = "url";
                final String OWM_NAME = "name";
                final String OWM_PREVIEWURL = "preview_url";
                final String OWM_EXTERNAL_URLS = "external_urls";
                final String OWM_SPOTIFY="spotify";

                final int ALBUMIMAGE640PX_SEQUENCE = 0;
                final int ALBUMIMAGE300PX_SEQUENCE = 1;

                // Get the JSON object representing the this track
                JSONObject artistObject = musicArray.getJSONObject(i);
                trackName = artistObject.getString(OWM_NAME);
                previewUrl = artistObject.getString(OWM_PREVIEWURL);

                JSONObject album = artistObject.getJSONObject(OWM_ALBUM);
                albumName = album.getString(OWM_NAME);

                JSONObject externalURL=artistObject.getJSONObject(OWM_EXTERNAL_URLS);
                external_urls=externalURL.getString(OWM_SPOTIFY);



                //JSONObject images= artistObject.getJSONArray(SPOTIFY_IMAGE).getJSONObject(SMALL_IMG_SEQUENCE);
                JSONArray images = album.getJSONArray(SPOTIFY_IMAGE);
                if (images.length() > 0) {
                    JSONObject image640 = images.getJSONObject(ALBUMIMAGE640PX_SEQUENCE);
                    if (image640.getString(OWM_URL) != null) {
                        albumImage640 = image640.getString(OWM_URL);
                    } else {
                        albumImage640 = "";

                    }
                    JSONObject image300 = images.getJSONObject(ALBUMIMAGE300PX_SEQUENCE);
                    if (image300.getString(OWM_URL) != null) {
                        albumImage300 = image300.getString(OWM_URL);
                    } else {
                        albumImage300 = "";
                    }
                } else {
                    //TO do add a pic holder
                    albumImage640 = "";
                    albumImage300 = "";
                }
                // music.add(new MusicData(artistName, imagesUrlS, id));
                music.add(new MusicData(musicID, trackName, albumName, albumImage640, albumImage300, previewUrl,external_urls));

            }
            //output the  the formated com.example.android.spotifystreamer.apk.data
            for (MusicData s : music) {
                Log.v(LOG_TAG, "Detail entry: " + s);
            }
            return music;

        }
        protected void onPostExecute(ArrayList<MusicData> result) {
            if (result != null) {
                mDetailAdapter.clear();
                mDetailAdapter.addAll(result);
            }

        }
