package wishlist.web;

import lombok.Data;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import wishlist.User;
import wishlist.UserWishMapping;
import wishlist.Wish;
import wishlist.data.UserRepository;
import wishlist.data.UserWishMappingRepository;
import wishlist.data.WishRepository;

import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.net.http.HttpResponse;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

@Controller
@RequestMapping("/searchPage")
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

    @GetMapping("/list")
    public String showUsersList(HttpServletResponse response) {
        response.setHeader("Cache-Control", "no-cache, no-store, must-revalidate");
        return "searchlist";
    }

    public void addUserWishlistToSession(String username, HttpSession session) {
        User userLookingFor = userRepository.findByUsername(username);
        List<UserWishMapping> mappings = userWishMappingRepository.findAllByUser(userLookingFor);

        List<Wish> searchedWishlist = new ArrayList<>();

        for (UserWishMapping mapping : mappings) {
            searchedWishlist.add(mapping.getWish());
        }

        session.setAttribute("searchedWishlist", searchedWishlist);
        session.setAttribute("searchedUsername", userLookingFor.getUsername());
    }

    @PostMapping("/list")
    public String searchingUsersWishes(String username, HttpSession session) {
        addUserWishlistToSession(username, session);

        return "searchlist";
    }

    @PostMapping("/list/reservation/{wishId}")
    public String reserveWish(@PathVariable("wishId") int id, HttpSession session) {
        User currentUser = (User) SecurityContextHolder.getContext().getAuthentication().getPrincipal();
        Optional<Wish> wishToEdit = wishRepository.findById(id);

        if (wishToEdit.isPresent()) {
            Wish newWish = wishToEdit.get();
            newWish.setReservedBy(currentUser.getUsername());
            wishRepository.save(newWish);
        }

//        addUserWishlistToSession((String) session.getAttribute("searchedUsername"), session);

        return "redirect:/searchPage/list";
    }

    @PostMapping("/list/cancel/{wishId}")
    public String cancelReservedWish(@PathVariable("wishId") int id, HttpSession session) {
        Optional<Wish> wishToEdit = wishRepository.findById(id);

        if (wishToEdit.isPresent()) {
            Wish newWish = wishToEdit.get();
            newWish.setReservedBy(null);
            wishRepository.save(newWish);
        }

//        addUserWishlistToSession((String) session.getAttribute("searchedUsername"), session);

        return "redirect:/searchPage/list";
    }

}
