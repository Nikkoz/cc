from .main import Main

class CThebitcoinnews(Main):
    def __init__(self, link, posts, handbook):
        Main.__init__(self, link, posts, handbook)

        self.menu = [
            'Breaking Bitcoin News',
            'The Bitcoin News',
            'Bitcoin News',
            'The Ethereum News',
            'Darknet'
        ]

        self.result = []

    def start(self):
        try:
            menu = self.get_menu('id', 'menu-top2-1')

            for page in menu:
                self.get_news(page['url'], page['title'])

            self.log.write("End: added {0} posts".format(len(self.result)))
        except RuntimeError as error:
            self.log.write("Error: {0}".format(error))

    def get_news(self, url, section):
        self.set_file(url)

        soup = self.soup()

        big_wrapper = soup.find('div', {'class': 'td-big-grid-wrapper'})
        main_content = soup.find('div', {'class': 'td-ss-main-content'})

        try:
            blocks = big_wrapper.find_all('div', {'class': 'td-big-grid-post'})
        except AttributeError:
            raise RuntimeError("structure of the news list has changed")

        try:
            posts = main_content.find_all('div', {'class': 'td-block-span6'})
        except AttributeError:
            raise RuntimeError("structure of the news list has changed")

        blocks = blocks + posts

        if not (blocks):
            raise RuntimeError("structure of the news list has changed")

        for block in blocks:
            url = self.check_url(block.find('h3', {'class': 'entry-title'}).find('a', {'rel': 'bookmark'}).get('href'))

            try:
                post = self.get_post(url)

                if post:
                    if post['title'] in self.posts:
                        continue

                    if self.check_date(post['date']) is None:
                        break

                    handbook = self.check_handbook_post(post['title'], post['content'])

                    if handbook:
                        self.result.append({
                            'url': url,
                            'title': post['title'],
                            'date': post['date'],
                            'section': section,
                            'text': post['content'],
                            'handbook': handbook
                        })

                        self.posts.append(post['title'])

            except Warning as error:
                self.log.write("Error: {0}".format(error))

    def get_post(self, url):
        if url is None:
            return

        self.set_file(url)

        soup = self.soup()

        content = soup.find('div', {'class': 'td-post-content'})
        date = soup.find('time', {'class': 'entry-date'})

        if content is None or date is None:
            raise Warning("structure of the news post has changed. Post link: {0}".format(url))

        title = soup.find('h1', {'class': 'entry-title'}).text

        text = []
        for div in content.find_all('div'):
            if not div is None:
                div.extract()

        for p in content.find_all('p'):
            script = p.script

            if not script is None:
                script.extract()

            text.append(self.clear(p.text))

        return {
            'content': '<br>'.join(text),
            'date': date.get('datetime'),
            'title': title.strip()
        }