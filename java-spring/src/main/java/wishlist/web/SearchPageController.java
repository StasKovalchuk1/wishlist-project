package wishlist.web;

import lombok.Data;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import wishlist.User;
import wishlist.UserWishMapping;
import wishlist.Wish;
import wishlist.data.UserRepository;
import wishlist.data.UserWishMappingRepository;
import wishlist.data.WishRepository;

import java.util.ArrayList;
import java.util.List;

@Controller
@RequestMapping("/search")
@Data
public class SearchPageController {

    private UserRepository userRepository;

    private WishRepository wishRepository;

    private UserWishMappingRepository userWishMappingRepository;

    @Autowired
    public SearchPageController(UserRepository userRepository,
                                WishRepository wishRepository,
                                UserWishMappingRepository userWishMappingRepository) {
        this.userRepository = userRepository;
        this.wishRepository = wishRepository;
        this.userWishMappingRepository = userWishMappingRepository;
    }

    @GetMapping
    public String showSearchPage() { return "searchPage"; }

    @PostMapping
    public String searchingUsersWishes(String username, Model model) {
        User userLookingFor = userRepository.findByUsername(username);
        List<UserWishMapping> mappings = userWishMappingRepository.findAllByUser(userLookingFor);

        List<Wish> searchedWishlist = new ArrayList<>();

        for (UserWishMapping mapping : mappings) {
            searchedWishlist.add(mapping.getWish());
        }

        model.addAttribute("searchedWishlist", searchedWishlist);
        model.addAttribute("searchedUsername", userLookingFor.getUsername());

        return "searchlist";
    }

}
