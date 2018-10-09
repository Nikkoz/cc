from .main import Main

class CCryptoanswers(Main):
    def __init__(self, link, posts, handbook):
        Main.__init__(self, link, posts, handbook)

        self.menu = []

        self.result = []
        self.titles = []
        
    def start(self):
        print('start')